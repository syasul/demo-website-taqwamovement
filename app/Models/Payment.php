<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'gateway',
        'gateway_transaction_id',
        'payment_method',
        'amount',
        'status',
        'raw_payload',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'raw_payload' => 'json',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the order associated with this payment.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
