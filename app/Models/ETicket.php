<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ETicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'e_tickets';

    protected $fillable = [
        'order_item_id',
        'ticket_code',
        'qr_payload',
        'is_checked_in',
        'checked_in_at',
        'checked_in_by',
    ];

    protected $casts = [
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    /**
     * Get the order item associated with this e-ticket.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the user who checked in this e-ticket.
     */
    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
