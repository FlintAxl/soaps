<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $newStatus;
    public $adminNote;

    public function __construct(Order $order, string $newStatus, string $adminNote = null)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
        $this->adminNote = $adminNote;
    }

    public function build()
    {
        return $this->subject("Order #{$this->order->id} Status Updated")
                    ->markdown('emails.order-status-updated');
    }
}
