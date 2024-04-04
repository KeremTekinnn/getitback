<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Setting;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RideMail;

class RideController extends Controller
{

    public function create()
    {
        $step = 'ride-create';
        $setting = Setting::find(1);
        $pricePerKm = $setting->price_per_km;

        return view('ride.create', ['pricePerKm' => $pricePerKm, 'step' => $step]);
    }

    public function getRideInformation(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'pickup' => 'required|string|max:255',
            'dropoff' => 'required|string|max:255',
            'date' => 'required|date',
            'distance' => 'required|numeric',
            'cost' => 'required|numeric',
        ]);

        // Redirect to payment page with filled data
        return redirect()->route('ride.payment', $validatedData);
    }

    public function store(Request $request)
    {
        // Retrieve the ride information from the session
        $rideData = session()->get('ride');

        // Validate payment data
        $validatedData = $request->validate([
            'payment_method' => 'required|string|max:255',
            'payment_id' => 'required|string|max:255',
        ]);

        // Set your Stripe API key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $rideData['cost'] * 100, // Stripe requires the amount in cents
            'currency' => 'usd', // Change this to your desired currency
            'payment_method' => $validatedData['payment_method'],
            'confirm' => true,
            'description' => 'Ride payment',
        ]);

        // Check if payment succeeded
        if ($paymentIntent->status === 'succeeded') {
            // Create a new Ride
            $ride = Ride::create([
                'user_id' => Auth::id(),
                'pickup' => $rideData['pickup'],
                'dropoff' => $rideData['dropoff'],
                'date' => $rideData['date'],
                'distance' => $rideData['distance'],
                'status' => 'completed',
            ]);

            // Create an invoice for the ride
            $invoice = Invoice::create([
                'ride_id' => $ride->id,
                'amount' => $rideData['cost'],
                'status' => 'paid',
            ]);

            // Send Ride mail to user
            Mail::to($request->user())->send(new RideMail($ride, $invoice));

            // Clear ride data from session
            session()->forget('ride');

            session()->flash('success', 'Payment successful and ride booked successfully');
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Payment failed');
            return redirect()->back();
        }
    }

    public function createPayment()
    {
        $step = 'ride-payment';
        $setting = Setting::find(1);
        $pricePerKm = $setting ? $setting->price_per_km : 0; // Set a default value if the Setting model does not exist or price_per_km is not set

        // Calculate cost based on distance and price per kilometer
        $distance = request('distance');
        $cost = $distance * $pricePerKm;

        return view('ride.payment', ['pricePerKm' => $pricePerKm, 'step' => $step, 'cost' => $cost]);
    }

}
