<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_session_id',
        'order',
        'topic_text',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the session that owns the topic.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(EventSession::class, 'event_session_id');
    }
}
