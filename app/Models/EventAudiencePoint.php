<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAudiencePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'order',
        'text',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the event that owns the audience point.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
