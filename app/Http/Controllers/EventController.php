<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of public events.
     */
    public function index()
    {
        $events = Event::where('status', \App\Enums\EventStatus::PUBLISHED)
            ->with(['phase', 'speakers'])
            ->orderBy('date', 'desc')
            ->get();

        return view('pages.event-index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Eager load all relations to prevent N+1 query problems
        $event->load([
            'phase',
            'sessions.topics',
            'agendaItems',
            'audiencePoints',
            'speakers'
        ]);

        // Get value propositions
        $features = \App\Models\Testimonial::where('type', 'feature')
            ->orderBy('order', 'asc')
            ->get();

        return view('pages.event-detail', compact('event', 'features'));
    }

    /**
     * Show booking and registration page for specified event.
     */
    public function booking(Event $event)
    {
        $event->load([
            'phase',
            'speakers'
        ]);

        return view('pages.event-booking', compact('event'));
    }
}
