<?php

namespace App\Http\Controllers\Checkout;

use App\Contracts\PaymentGatewayInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentCallbackController extends Controller
{
    protected PaymentGatewayInterface $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Handle payment gateway webhook callback.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        
        Log::info('Payment Callback Received', ['payload' => $payload]);

        // 1. Verify webhook signature
        if (!$this->gateway->verifySignature($payload)) {
            Log::warning('Payment Callback Invalid Signature', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $orderNumber = $payload['order_id'] ?? '';
        $transactionStatus = $payload['transaction_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? '';
        $gatewayTransactionId = $payload['transaction_id'] ?? '';

        // 2. Fetch the corresponding Order
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            Log::error('Payment Callback Order Not Found', ['order_number' => $orderNumber]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 3. Handle Idempotency: If already paid or processed, skip
        if ($order->status === 'paid' && in_array($transactionStatus, ['capture', 'settlement'])) {
            return response()->json(['message' => 'Order already processed']);
        }

        try {
            DB::transaction(function () use ($order, $transactionStatus, $paymentType, $gatewayTransactionId, $payload) {
                // Determine order status transitions
                $oldStatus = $order->status;
                $newStatus = $order->status;

                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    $newStatus = 'paid';
                    $order->paid_at = now();
                } elseif (in_array($transactionStatus, ['deny', 'cancel'])) {
                    $newStatus = 'cancelled';
                } elseif ($transactionStatus === 'expire') {
                    $newStatus = 'expired';
                }

                // If status transitioned to paid
                if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                    $order->status = 'paid';
                    $order->save();

                    // Generate E-Tickets for this order
                    // Wait, we'll write this E-Ticket helper function / trigger the Job next!
                    $this->generateETickets($order);
                }

                // If status transitioned to failed/expired/cancelled, release stock and promo codes
                if (in_array($newStatus, ['expired', 'cancelled']) && !in_array($oldStatus, ['expired', 'cancelled', 'failed'])) {
                    $order->status = $newStatus;
                    $order->save();

                    // Release ticket stock
                    foreach ($order->items as $item) {
                        $ticketType = TicketType::lockForUpdate()->find($item->ticket_type_id);
                        if ($ticketType) {
                            $ticketType->decrement('sold_count', $item->qty);
                        }
                    }

                    // Release promo code quota if applied
                    if ($order->promoCode) {
                        $order->promoCode->decrement('used_count');
                    }
                }

                // Record or update Payment transaction log
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'gateway' => 'midtrans',
                        'gateway_transaction_id' => $gatewayTransactionId,
                        'payment_method' => $paymentType,
                        'amount' => $order->total,
                        'status' => $transactionStatus,
                        'raw_payload' => $payload,
                        'paid_at' => $newStatus === 'paid' ? now() : null,
                    ]
                );
            });

            return response()->json(['message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            Log::error('Payment Callback Processing Exception', [
                'order_number' => $orderNumber,
                'message' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Helper to generate E-Tickets for a paid order.
     */
    protected function generateETickets(Order $order)
    {
        // Fetch order items
        $order->load('items');

        foreach ($order->items as $item) {
            // Check if e-ticket already exists to avoid double generation
            if ($item->eTicket) continue;

            // Generate TQW-{EVENTCODE}-{RANDOM8} code
            $eventCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $order->event->title), 0, 3));
            $randomString = strtoupper(Str::random(8));
            $ticketCode = "TQW-{$eventCode}-{$randomString}";

            // Encrypted / Secure Payload signature for check-in validation
            $qrPayload = json_encode([
                'ticket_code' => $ticketCode,
                'order_number' => $order->order_number,
                'attendee_name' => $item->attendee_name,
                'attendee_email' => $item->attendee_email,
                'hash' => hash_hmac('sha256', $ticketCode, config('app.key')),
            ]);

            \App\Models\ETicket::create([
                'order_item_id' => $item->id,
                'ticket_code' => $ticketCode,
                'qr_payload' => $qrPayload,
                'is_checked_in' => false,
            ]);
        }

        // Trigger notifications inside queue
        // We will write the SendTicketNotificationJob next!
        dispatch(new \App\Jobs\SendTicketNotificationJob($order));
    }
}
