<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'quota',
        'used_count',
        'valid_from',
        'valid_until',
        'ticket_type_id',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'quota' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Get the ticket type that this promo code is limited to.
     */
    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    /**
     * Check if the promo code is valid now.
     */
    public function isValid(?int $ticketTypeId = null): bool
    {
        if ($this->used_count >= $this->quota) {
            return false;
        }

        $now = now();
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->ticket_type_id && $ticketTypeId !== null && $this->ticket_type_id !== $ticketTypeId) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percentage') {
            return round(($subtotal * ($this->discount_value / 100)), 2);
        }

        return min($this->discount_value, $subtotal);
    }
}
