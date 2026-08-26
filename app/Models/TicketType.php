<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quota',
        'sold_count',
        'max_per_transaction',
        'sale_start_at',
        'sale_end_at',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quota' => 'integer',
        'sold_count' => 'integer',
        'max_per_transaction' => 'integer',
        'sale_start_at' => 'datetime',
        'sale_end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the event that owns the ticket type.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the order items for this ticket type.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if the ticket type is currently available for purchase.
     */
    public function isAvailable(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->sold_count >= $this->quota) {
            return false;
        }

        $now = now();
        if ($this->sale_start_at && $now->lt($this->sale_start_at)) {
            return false;
        }

        if ($this->sale_end_at && $now->gt($this->sale_end_at)) {
            return false;
        }

        return true;
    }

    /**
     * Get available stock count.
     */
    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->quota - $this->sold_count);
    }
}
