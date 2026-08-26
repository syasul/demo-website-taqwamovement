<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\Request;

class EventSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventSessions = EventSession::with('event')->orderBy('event_id')->orderBy('order')->paginate(15);
        return view('admin.event-sessions.index', compact('eventSessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', \App\Enums\EventStatus::PUBLISHED)->get();
        return view('admin.event-sessions.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order' => 'required|integer|min:1',
        ]);

        // Autogenerate session number
        $latestSession = EventSession::where('event_id', $validated['event_id'])->orderBy('session_number', 'desc')->first();
        $validated['session_number'] = $latestSession ? $latestSession->session_number + 1 : 1;

        EventSession::create($validated);

        return redirect()->route('admin.event-sessions.index')
            ->with('success', 'Sesi event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventSession $eventSession)
    {
        $events = Event::where('status', \App\Enums\EventStatus::PUBLISHED)->get();
        return view('admin.event-sessions.edit', compact('eventSession', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventSession $eventSession)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order' => 'required|integer|min:1',
        ]);

        $eventSession->update($validated);

        return redirect()->route('admin.event-sessions.index')
            ->with('success', 'Sesi event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventSession $eventSession)
    {
        $eventSession->delete();
        return redirect()->route('admin.event-sessions.index')
            ->with('success', 'Sesi event berhasil dihapus.');
    }
}
