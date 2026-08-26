<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Speaker extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'role_title',
        'bio',
        'instagram_url',
        'photo_media_id',
    ];

    /**
     * Register Media Collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->format('webp');

                $this->addMediaConversion('medium')
                    ->width(400)
                    ->height(400)
                    ->format('webp');
            });
    }

    /**
     * Get the events for the speaker.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
