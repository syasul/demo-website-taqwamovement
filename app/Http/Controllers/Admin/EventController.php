<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with('phase')->orderBy('date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        activity()
            ->performedOn($event)
            ->log('menghapus event');

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil di-soft-delete.');
    }
}
