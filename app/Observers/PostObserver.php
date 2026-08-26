<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     */
    public function creating(Post $post): void
    {
        if (empty($post->slug)) {
            $post->slug = $this->generateUniqueSlug($post->title);
        }
    }

    /**
     * Handle the Post "updating" event.
     */
    public function updating(Post $post): void
    {
        if ($post->isDirty('title') && !$post->isDirty('slug')) {
            $post->slug = $this->generateUniqueSlug($post->title, $post->id);
        }
    }

    /**
     * Generate a unique slug for the Post model.
     */
    private function generateUniqueSlug(string $title, int $excludeId = 0): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->where('id', '!=', $excludeId)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
