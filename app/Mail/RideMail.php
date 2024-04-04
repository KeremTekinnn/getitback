<?php

namespace App\Mail;

use App\Models\Ride;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $ride;

    public function __construct(Ride $ride, Invoice $invoice)
    {
        $this->ride = $ride;
        $this->invoice = $invoice;
    }

    public function build()
    {
        return $this->subject('Ride Booked Successfully')
            ->markdown('emails.ride_mail' , ['ride' => $this->ride, 'invoice' => $this->invoice]) ;
    }
}
