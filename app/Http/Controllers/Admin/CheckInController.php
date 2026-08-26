<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckInController extends Controller
{
    /**
     * Display the QR Code check-in scanner view.
     */
    public function showScanner()
    {
        return view('admin.check-in.scanner');
    }

    /**
     * Validate and process ticket check-in.
     */
    public function processScan(Request $request)
    {
        $qrPayload = $request->input('qr_payload');

        if (empty($qrPayload)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data QR tidak terdeteksi.'
            ], 400);
        }

        // Try to decode JSON
        $data = json_decode($qrPayload, true);

        if (!$data || empty($data['ticket_code']) || empty($data['hash'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format QR Code tidak valid / bukan tiket Taqwa.'
            ], 422);
        }

        $ticketCode = $data['ticket_code'];
        $hash = $data['hash'];

        // 1. Verify QR signature hash integrity (anti-tamper check)
        $expectedHash = hash_hmac('sha256', $ticketCode, config('app.key'));

        if (!hash_equals($expectedHash, $hash)) {
            Log::warning('Check-in Signature Validation Failed', ['ticket_code' => $ticketCode]);
            return response()->json([
                'status' => 'error',
                'message' => 'Peringatan: Tanda tangan tiket tidak sah (Tiket Palsu)!'
            ], 403);
        }

        // 2. Fetch ticket from database
        $eTicket = ETicket::where('ticket_code', $ticketCode)
            ->with('orderItem')
            ->first();

        if (!$eTicket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode tiket tidak terdaftar di database.'
            ], 404);
        }

        // 3. Check if already checked in
        if ($eTicket->is_checked_in) {
            $checkedInTime = $eTicket->checked_in_at ? $eTicket->checked_in_at->format('H:i') : '';
            return response()->json([
                'status' => 'error',
                'message' => "Tiket sudah digunakan sebelumnya pada pukul {$checkedInTime} WIB!"
            ], 409);
        }

        // 4. Perform check-in registration
        $eTicket->is_checked_in = true;
        $eTicket->checked_in_at = now();
        $eTicket->checked_in_by = auth()->id();
        $eTicket->save();

        Log::info('Attendee checked in successfully', ['ticket_code' => $ticketCode, 'staff' => auth()->id()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi Check-In Berhasil!',
            'attendee_name' => $eTicket->orderItem->attendee_name ?? 'Peserta',
            'attendee_email' => $eTicket->orderItem->attendee_email ?? '',
            'ticket_code' => $eTicket->ticket_code,
        ]);
    }
}
