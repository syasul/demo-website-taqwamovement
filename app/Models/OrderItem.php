<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'ticket_type_id',
        'qty',
        'price_each',
        'attendee_name',
        'attendee_email',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price_each' => 'decimal:2',
    ];

    /**
     * Get the order that owns this item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the ticket type for this item.
     */
    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    /**
     * Get the e-ticket associated with this order item.
     */
    public function eTicket(): HasOne
    {
        return $this->hasOne(ETicket::class);
    }
}
