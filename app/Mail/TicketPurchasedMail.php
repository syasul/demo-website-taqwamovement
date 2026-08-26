<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketPurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $this->order->load(['event', 'items.eTicket', 'user']);

        // Compile PDF E-Ticket in memory
        $pdf = Pdf::loadView('pdf.e-ticket', [
            'order' => $this->order,
            'event' => $this->order->event,
            'items' => $this->order->items
        ]);

        return $this->subject('Konfirmasi Pembayaran & E-Ticket Anda - Taqwa Movement')
            ->view('emails.ticket-purchased')
            ->attachData($pdf->output(), 'e-ticket-' . $this->order->order_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
