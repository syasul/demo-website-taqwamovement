<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of user's active paid tickets.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'paid')
            ->with(['event', 'items.eTicket'])
            ->latest()
            ->get();

        return view('pages.dashboard.my-tickets', [
            'orders' => $orders
        ]);
    }

    /**
     * Display ticket details and QR codes.
     */
    public function show(Order $order)
    {
        if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $order->load(['event', 'items.eTicket', 'items.ticketType']);

        return view('pages.dashboard.ticket-detail', [
            'order' => $order,
            'event' => $order->event,
            'items' => $order->items
        ]);
    }

    /**
     * Download E-Ticket as PDF.
     */
    public function downloadPdf(Order $order)
    {
        if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $order->load(['event', 'items.eTicket', 'items.ticketType']);

        $pdf = Pdf::loadView('pdf.e-ticket', [
            'order' => $order,
            'event' => $order->event,
            'items' => $order->items
        ]);

        return $pdf->download("e-ticket-{$order->order_number}.pdf");
    }

    /**
     * Display listing of transaction logs.
     */
    public function transactions()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['event', 'payment'])
            ->latest()
            ->get();

        return view('pages.dashboard.transactions', [
            'orders' => $orders
        ]);
    }
}
