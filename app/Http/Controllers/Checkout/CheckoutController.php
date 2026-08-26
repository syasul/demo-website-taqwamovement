<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show payment status page.
     */
    public function status(Order $order)
    {
        // Restrict status page access to the order owner or admin
        if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $order->load(['event', 'items.eTicket', 'payment']);

        return view('pages.checkout-status', [
            'order' => $order,
            'event' => $order->event,
            'payment' => $order->payment
        ]);
    }

    /**
     * Check order status JSON for AJAX polling.
     */
    public function checkStatusJson(Order $order)
    {
        if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => $order->status,
            'redirect_url' => route('dashboard.my-tickets') // We will build the my-tickets route next in Phase 5!
        ]);
    }
}
