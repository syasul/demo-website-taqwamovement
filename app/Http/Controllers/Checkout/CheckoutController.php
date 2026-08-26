<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show payment status page.
     */
    public function status(Order $order)
    {
        // Restrict status page access to the order owner or admin if the order is associated with a user
        if ($order->user_id !== null) {
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
                abort(403);
            }
        }

        $order->load(['event', 'items.eTicket', 'payment']);

        return view('pages.checkout-status', [
            'order' => $order,
            'event' => $order->event,
            'payment' => $order->payment
        ]);
    }

    /**
     * Check order status JSON for AJAX polling.
     */
    public function checkStatusJson(Order $order)
    {
        if ($order->user_id !== null) {
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        return response()->json([
            'status' => $order->status,
            'redirect_url' => auth()->check() ? route('dashboard.my-tickets') : '/'
        ]);
    }

    /**
     * Simulate a successful payment for testing/dev purposes.
     */
    public function simulatePay(Order $order)
    {
        if ($order->status === 'paid') {
            return redirect()->route('checkout.status', $order->order_number);
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
                // Update Order Status
                $order->status = 'paid';
                $order->paid_at = now();
                $order->save();

                // Generate E-Tickets for this order
                $order->load(['items', 'event']);

                foreach ($order->items as $item) {
                    if ($item->eTicket) continue;

                    $eventCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $order->event->title), 0, 3));
                    $randomString = strtoupper(\Illuminate\Support\Str::random(8));
                    $ticketCode = "TQW-{$eventCode}-{$randomString}";

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

                // Record or update Payment transaction log
                \App\Models\Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'gateway' => 'manual_mock',
                        'gateway_transaction_id' => 'mock-tx-' . \Illuminate\Support\Str::random(10),
                        'payment_method' => 'manual_transfer',
                        'amount' => $order->total,
                        'status' => 'settlement',
                        'raw_payload' => ['simulation' => true],
                        'paid_at' => now(),
                    ]
                );
            });

            // Dispatch notification job inside try-catch to avoid breaking if queue connection is not running
            try {
                dispatch(new \App\Jobs\SendTicketNotificationJob($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Could not dispatch ticket notification job: ' . $e->getMessage());
            }

            return redirect()->route('checkout.status', $order->order_number)->with('success', 'Simulasi pembayaran berhasil.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Payment Simulation Error', [
                'order' => $order->order_number,
                'message' => $e->getMessage()
            ]);
            return redirect()->route('checkout.status', $order->order_number)->with('error', 'Gagal memproses simulasi pembayaran: ' . $e->getMessage());
        }
    }
}
