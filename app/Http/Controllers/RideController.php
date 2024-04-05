<?php
namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Setting;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RideMail;
use Stripe\Stripe;
use Stripe\Checkout\Session; // Add missing import statement

class RideController extends Controller
{
    public function create()
    {
        $step = 'ride-create';
        $setting = Setting::find(1);
        $pricePerKm = $setting->price_per_km;

        return view('ride.create', ['pricePerKm' => $pricePerKm, 'step' => $step]);
    }


    //store the ride details and invoice
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'pickup' => 'required|string|max:255',
            'dropoff' => 'required|string|max:255',
            'date' => 'required|date',
            'distance' => 'required|numeric|between:0,999999.99',
            'cost' => 'required|numeric|',
        ]);
    
        // Create a new Ride with the validated data
        $ride = Ride::create([
            'user_id' => Auth::id(),
            'pickup' => $validatedData['pickup'],
            'dropoff' => $validatedData['dropoff'],
            'date' => $validatedData['date'],
            'distance' => $validatedData['distance'],
            'cost' => $validatedData['cost'],
        ]);
    
        // Create a new Invoice
        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'ride_id' => $ride->id,
            'amount' => $validatedData['cost'],
        ]);

        // Send an email to the user
        Mail::to(Auth::user()->email)->send(new RideMail($ride));

        session()->flash('success', 'Ride created successfully!');
        return redirect()->route('dashboard');
    }
}