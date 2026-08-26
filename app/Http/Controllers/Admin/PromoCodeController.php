<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\TicketType;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promoCodes = PromoCode::with('ticketType.event')->latest()->paginate(15);
        return view('admin.promo-codes.index', compact('promoCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticketTypes = TicketType::with('event')->get();
        return view('admin.promo-codes.create', compact('ticketTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code|max:50',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'ticket_type_id' => 'nullable|exists:ticket_types,id',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['used_count'] = 0;

        PromoCode::create($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromoCode $promoCode)
    {
        $ticketTypes = TicketType::with('event')->get();
        return view('admin.promo-codes.edit', compact('promoCode', 'ticketTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $promoCode->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'ticket_type_id' => 'nullable|exists:ticket_types,id',
        ]);

        $validated['code'] = strtoupper($validated['code']);

        $promoCode->update($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil dihapus.');
    }

    /**
     * Remove multiple promo codes from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            PromoCode::whereIn('id', $ids)->delete();
            return redirect()->route('admin.promo-codes.index')->with('success', count($ids) . ' kode promo terpilih berhasil dihapus.');
        }
        return redirect()->route('admin.promo-codes.index')->with('error', 'Tidak ada kode promo yang dipilih.');
    }
}
