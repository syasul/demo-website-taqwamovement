<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketTypes = TicketType::with('event')->latest()->paginate(15);
        return view('admin.ticket-types.index', compact('ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', \App\Enums\EventStatus::PUBLISHED)->get();
        return view('admin.ticket-types.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'max_per_transaction' => 'required|integer|min:1',
            'sale_start_at' => 'required|date',
            'sale_end_at' => 'required|date|after:sale_start_at',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sold_count'] = 0;

        TicketType::create($validated);

        return redirect()->route('admin.ticket-types.index')
            ->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketType $ticketType)
    {
        $events = Event::where('status', \App\Enums\EventStatus::PUBLISHED)->get();
        return view('admin.ticket-types.edit', compact('ticketType', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'max_per_transaction' => 'required|integer|min:1',
            'sale_start_at' => 'required|date',
            'sale_end_at' => 'required|date|after:sale_start_at',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $ticketType->update($validated);

        return redirect()->route('admin.ticket-types.index')
            ->with('success', 'Jenis tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();
        return redirect()->route('admin.ticket-types.index')
            ->with('success', 'Jenis tiket berhasil dihapus.');
    }

    /**
     * Remove multiple ticket types from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TicketType::whereIn('id', $ids)->delete();
            return redirect()->route('admin.ticket-types.index')->with('success', count($ids) . ' jenis tiket terpilih berhasil dihapus.');
        }
        return redirect()->route('admin.ticket-types.index')->with('error', 'Tidak ada jenis tiket yang dipilih.');
    }
}
