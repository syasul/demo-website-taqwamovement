<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireUnpaidOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire pending unpaid orders that have exceeded their payment window and release ticket stocks.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting check for expired unpaid orders...');

        $expiredOrders = Order::where('status', 'pending')
            ->where('expired_at', '<', now())
            ->with(['items', 'promoCode'])
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired unpaid orders found.');
            return 0;
        }

        $this->info("Found {$expiredOrders->count()} expired orders to process.");

        foreach ($expiredOrders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    // Update Order Status
                    $order->status = 'expired';
                    $order->save();

                    // Release ticket stock
                    foreach ($order->items as $item) {
                        $ticketType = TicketType::lockForUpdate()->find($item->ticket_type_id);
                        if ($ticketType) {
                            $ticketType->decrement('sold_count', $item->qty);
                            $this->line("Released stock for: {$ticketType->name} (Qty: {$item->qty})");
                        }
                    }

                    // Release promo code if applied
                    if ($order->promoCode) {
                        $order->promoCode->decrement('used_count');
                        $this->line("Released promo code usage: {$order->promoCode->code}");
                    }

                    // Update payment log status if exists
                    Payment::updateOrCreate(
                        ['order_id' => $order->id],
                        [
                            'gateway' => 'midtrans',
                            'amount' => $order->total,
                            'status' => 'expired',
                        ]
                    );

                    Log::info("Order Expired Successfully", ['order_number' => $order->order_number]);
                    $this->info("Expired Order: {$order->order_number}");
                });
            } catch (\Exception $e) {
                Log::error("Failed to expire order", [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
                $this->error("Failed to expire Order: {$order->order_number}. Error: {$e->getMessage()}");
            }
        }

        $this->info('Expired orders clean up complete.');
        return 0;
    }
}
