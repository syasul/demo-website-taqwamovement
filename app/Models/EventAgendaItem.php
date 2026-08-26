<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAgendaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'session_group',
        'order',
        'title',
        'subtitle',
        'description',
        'duration_label',
    ];

    protected $casts = [
        'session_group' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the event that owns the agenda item.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
