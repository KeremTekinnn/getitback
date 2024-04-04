<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $ride;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $ride)
    {
        $this->invoice = $invoice;
        $this->ride = $ride;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Invoice')
            ->markdown('emails.invoice', ['ride' => $this->ride, 'invoice' => $this->invoice]);
    }
}
