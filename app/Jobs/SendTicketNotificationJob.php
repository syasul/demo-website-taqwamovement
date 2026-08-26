<?php

namespace App\Jobs;

use App\Mail\TicketPurchasedMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendTicketNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->order->load(['user', 'event']);

        try {
            Mail::to($this->order->user->email)->send(new TicketPurchasedMail($this->order));
            Log::info("E-Ticket Email Sent Successfully", ['order_number' => $this->order->order_number]);
        } catch (\Exception $e) {
            Log::error("Failed to Send E-Ticket Email", [
                'order_number' => $this->order->order_number,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
