<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'phase_id',
        'title',
        'tagline',
        'description',
        'date',
        'location',
        'ticket_url',
        'status',
        'meta_title',
        'meta_description',
        'og_image',
        'slug',
    ];

    protected $casts = [
        'status' => EventStatus::class,
        'date' => 'date',
    ];

    /**
     * Register Media Library Collections & Conversions.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
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

                $this->addMediaConversion('large')
                    ->width(1200)
                    ->height(800)
                    ->format('webp');
            });
    }

    /**
     * Get the phase that owns the event.
     */
    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }

    /**
     * Get the sessions for the event.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(EventSession::class)->orderBy('session_number', 'asc');
    }

    /**
     * Get the agenda rundown items for the event.
     */
    public function agendaItems(): HasMany
    {
        return $this->hasMany(EventAgendaItem::class)->orderBy('session_group', 'asc')->orderBy('order', 'asc');
    }

    /**
     * Get the audience checklist points for the event.
     */
    public function audiencePoints(): HasMany
    {
        return $this->hasMany(EventAudiencePoint::class)->orderBy('order', 'asc');
    }

    /**
     * Get the speakers for the event.
     */
    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class);
    }

    /**
     * Get the ticket types for this event.
     */
    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    /**
     * Get the orders associated with this event.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', EventStatus::PUBLISHED);
    }
}
