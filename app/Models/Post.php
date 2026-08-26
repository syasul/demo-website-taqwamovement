<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail_media_id',
        'author_name',
        'author_avatar',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'views_count',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    /**
     * Register Media Collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
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
     * Get the category that owns the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }
}
