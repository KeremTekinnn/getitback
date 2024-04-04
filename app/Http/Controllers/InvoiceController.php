<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Invoice;
use PDF;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;


class InvoiceController extends Controller
{
    public function generateInvoice(Ride $ride)
    {
        // Get the invoice related to the ride
        $invoice = Invoice::where('ride_id', $ride->id)->first();

        // Generate the invoice PDF from the invoice view
        $pdf = PDF::loadView('invoice', ['ride' => $ride, 'invoice' => $invoice]);

        // Save the PDF to a file
        $pdfPath = storage_path('app/public/invoices/invoice_' . $ride->id . '.pdf');
        $pdf->save($pdfPath);

        return $pdfPath;
    }

    public function download(Ride $ride)
    {
        // Generate the invoice for the ride
        $invoicePath = $this->generateInvoice($ride);

        // Return the invoice as a download response
        return response()->download($invoicePath);
    }

    public function sendInvoiceEmail(Ride $ride)
    {
        // Get the invoice related to the ride
        $invoice = Invoice::where('ride_id', $ride->id)->first();

        // Get the user who booked the ride
        $user = $ride->user;

        // Send the invoice as an email to the user
        Mail::to($user->email)->send(new InvoiceMail($invoice, $ride));

        return back()->with('success', 'Invoice email sent successfully!');
    }
}
