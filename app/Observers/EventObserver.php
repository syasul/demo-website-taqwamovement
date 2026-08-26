<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Str;

class EventObserver
{
    /**
     * Handle the Event "creating" event.
     */
    public function creating(Event $event): void
    {
        if (empty($event->slug)) {
            $event->slug = $this->generateUniqueSlug($event->title);
        }
    }

    /**
     * Handle the Event "updating" event.
     */
    public function updating(Event $event): void
    {
        if ($event->isDirty('title') && !$event->isDirty('slug')) {
            $event->slug = $this->generateUniqueSlug($event->title, $event->id);
        }
    }

    /**
     * Generate a unique slug for the Event model.
     */
    private function generateUniqueSlug(string $title, int $excludeId = 0): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Event::where('slug', $slug)->where('id', '!=', $excludeId)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
