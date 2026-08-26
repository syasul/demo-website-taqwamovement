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
        // Restrict status page access to the order owner or admin if the order is associated with a user
        if ($order->user_id !== null) {
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
                abort(403);
            }
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
        if ($order->user_id !== null) {
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if (auth()->id() !== $order->user_id && !auth()->user()->is_admin) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        return response()->json([
            'status' => $order->status,
            'redirect_url' => auth()->check() ? route('dashboard.my-tickets') : '/'
        ]);
    }
}
