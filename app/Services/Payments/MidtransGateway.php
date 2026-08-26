<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransGateway implements PaymentGatewayInterface
{
    protected string $serverKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key') ?? '';
        $this->isProduction = config('services.midtrans.is_production') ?? false;
        
        $this->baseUrl = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1' 
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    /**
     * Create a pending transaction on the gateway and return the token and redirect URL.
     */
    public function createTransaction(Order $order): array
    {
        $order->load(['user', 'items.ticketType']);

        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => 'ticket-' . $item->ticket_type_id,
                'price' => (int) $item->price_each,
                'quantity' => (int) $item->qty,
                'name' => $item->ticketType->name,
            ];
        }

        if ($order->discount > 0) {
            $itemDetails[] = [
                'id' => 'promo-discount',
                'price' => -(int) $order->discount,
                'quantity' => 1,
                'name' => 'Diskon Kupon',
            ];
        }

        if ($order->admin_fee > 0) {
            $itemDetails[] = [
                'id' => 'admin-fee',
                'price' => (int) $order->admin_fee,
                'quantity' => 1,
                'name' => 'Biaya Admin',
            ];
        }

        // Prepare Snap Payload
        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'minute',
                'duration' => 60,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':')
            ])->post($this->baseUrl . '/transactions', $payload);

            if ($response->failed()) {
                Log::error('Midtrans API Request Failed', [
                    'order' => $order->order_number,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Gagal menghubungi Payment Gateway: ' . $response->body());
            }

            $data = $response->json();
            return [
                'token' => $data['token'],
                'redirect_url' => $data['redirect_url']
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans API Exception', [
                'order' => $order->order_number,
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Verify if the webhook signature key matches (SHA512 validation).
     */
    public function verifySignature(array $payload): bool
    {
        if (empty($payload['signature_key'])) {
            return false;
        }

        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        // Signature validation formula: SHA512(order_id + status_code + gross_amount + server_key)
        $localSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($localSignature, $signatureKey);
    }
}
