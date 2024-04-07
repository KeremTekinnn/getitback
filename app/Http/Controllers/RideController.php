<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class RideController extends Controller
{
    public function create()
    {
        // Retrieve the price per kilometer from the settings
        $setting = Setting::find(1);
        $pricePerKm = $setting->price_per_km;
        // Return the ride booking form view
        return view('ride.create', ['pricePerKm' => $pricePerKm]);
    }

    public function checkout(Request $request)
    {
        // Validate the request data
        $request->validate([
            'pickup' => 'required',
            'dropoff' => 'required',
            'date' => 'required|date',
            'distance' => 'required|numeric',
            'cost' => 'required|numeric',
        ]);
        
        // Set the Stripe API key
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        // Create a new Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Total Cost',
                    ],
                    'unit_amount' => $request->cost * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('ride.create'),
        ]);
        // Store the form data in the session
        $request->session()->put('formData', $request->all());
        // Redirect to the checkout page
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        // Retrieve the form data from the session
        $formData = $request->session()->get('formData');

        // Check if the formData session data exists
        if (!$formData) {
            // Redirect to a different page if the formData session data does not exist
            return view('ride.success');
        }

        // Create a new Ride
        $ride = Ride::create([
            'user_id' => Auth::id(),
            'pickup' => $formData['pickup'],
            'dropoff' => $formData['dropoff'],
            'date' => $formData['date'],
            'distance' => $formData['distance'],
            'cost' => $formData['cost'],
            'status' => 'Pending',
        ]);

        // Create a new Order
        $invoice= Invoice::create([
            'ride_id' => $ride->id,
            'status' => 'paid',
            'amount' => $formData['cost'],
        ]);

        Mail::to(Auth::user()->email)->send(new InvoiceMail($invoice));

        // Clear the formData session data after creating the Ride and Invoice
        $request->session()->forget('formData');
        // Redirect to the success page
        return view('ride.success')->with('success', 'Ride booked successfully!');
    }
}
