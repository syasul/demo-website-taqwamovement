<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List all customer orders.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        
        $query = Order::with(['user', 'event', 'payment'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $status
        ]);
    }

    /**
     * Show report dashboard with date range filtering.
     */
    public function report(Request $request)
    {
        $startDateStr = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDateStr = $request->input('end_date', now()->format('Y-m-d'));

        $startDate = Carbon::parse($startDateStr)->startOfDay();
        $endDate = Carbon::parse($endDateStr)->endOfDay();

        // 1. Paid orders in date range
        $ordersQuery = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalOrdersCount = $ordersQuery->count();
        $totalRevenue = $ordersQuery->sum('total');
        $totalDiscount = $ordersQuery->sum('discount');
        $averageOrderValue = $totalOrdersCount > 0 ? $totalRevenue / $totalOrdersCount : 0;

        // 2. Total tickets sold
        $totalTicketsSold = OrderItem::whereHas('order', function ($q) use ($startDate, $endDate) {
            $q->where('status', 'paid')->whereBetween('created_at', [$startDate, $endDate]);
        })->sum('qty');

        // 3. Sales grouped by event
        $salesByEvent = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('event_id', DB::raw('SUM(total) as revenue'), DB::raw('COUNT(id) as count'))
            ->with('event')
            ->groupBy('event_id')
            ->orderBy('revenue', 'desc')
            ->get();

        // 4. Ticket popularity
        $salesByTicketType = OrderItem::whereHas('order', function ($q) use ($startDate, $endDate) {
            $q->where('status', 'paid')->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->select('ticket_type_id', DB::raw('SUM(qty) as qty_sold'), DB::raw('SUM(price_each * qty) as revenue'))
        ->with('ticketType')
        ->groupBy('ticket_type_id')
        ->orderBy('qty_sold', 'desc')
        ->get();

        // 5. Daily Sales chart data
        $dailySales = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => Carbon::parse($item->date)->format('d M'),
                    'value' => (float) $item->total
                ];
            });

        return view('admin.reports.index', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'totalOrdersCount' => $totalOrdersCount,
            'totalRevenue' => $totalRevenue,
            'totalDiscount' => $totalDiscount,
            'averageOrderValue' => $averageOrderValue,
            'totalTicketsSold' => $totalTicketsSold,
            'salesByEvent' => $salesByEvent,
            'salesByTicketType' => $salesByTicketType,
            'dailySales' => $dailySales
        ]);
    }

    /**
     * Export paid orders to CSV file.
     */
    public function export(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date', now()->subDays(30)->format('Y-m-d')))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', now()->format('Y-m-d')))->endOfDay();

        $orders = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'event'])
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-transaksi.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No. Order', 'Nama Pelanggan', 'Email', 'Event', 'Subtotal', 'Diskon', 'Fee', 'Total', 'Tanggal Lunas'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name ?? '-',
                    $order->user->email ?? '-',
                    $order->event->title ?? '-',
                    $order->subtotal,
                    $order->discount,
                    $order->admin_fee,
                    $order->total,
                    $order->paid_at ? $order->paid_at->format('Y-m-d H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
