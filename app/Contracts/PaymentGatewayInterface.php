<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Create a pending transaction on the gateway and return the token and redirect URL.
     *
     * @param Order $order
     * @return array{token: string, redirect_url: string}
     */
    public function createTransaction(Order $order): array;

    /**
     * Verify if the webhook request payload signature is valid.
     *
     * @param array $payload
     * @return bool
     */
    public function verifySignature(array $payload): bool;
}
