<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $orderDetails)
    {
        $this->order = $order;
        $this->orderDetails = $orderDetails;
    }

    public function build()
    {
        return $this->subject('Votre commande')
                    ->view('emails.order-details');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
