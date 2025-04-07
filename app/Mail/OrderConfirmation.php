<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Soap Haven Order #' . $this->order->id)
                    ->view('emails.order-confirmation')
                    ->attachData($this->generatePDF(), 'Order_' . $this->order->id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    protected function generatePDF()
    {
        // ✅ Use the Pdf facade (capital P only)
        $pdf = Pdf::loadView('pdf.order-receipt', ['order' => $this->order]);

        return $pdf->output();
    }
}
