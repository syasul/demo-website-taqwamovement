<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EventSession extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'session_number',
        'title',
        'description',
        'start_time',
        'end_time',
        'poster_media_id',
    ];

    /**
     * Register Media Collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('poster')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->format('webp');

                $this->addMediaConversion('medium')
                    ->width(600)
                    ->height(400)
                    ->format('webp');
            });
    }

    /**
     * Get the event that owns the session.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the topics focus for this session.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(EventTopic::class)->orderBy('order', 'asc');
    }
}
