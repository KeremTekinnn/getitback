<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ride;
use App\Models\Setting;

class AdminDashboard extends Component
{
    public $pricePerKm;
    public $status = 'all';
    public $rides;
    public $selectedStatus = [];

    protected $listeners = ['refreshRides' => 'fetchRides'];

    public function mount()
    {
        // Fetch the price per kilometer from the settings
        $this->pricePerKm = Setting::find(1)->price_per_km;
        $this->fetchRides();
    }

    public function render()
    {
        // Render the admin dashboard view
        return view('livewire.admin-dashboard');
    }

    public function fetchRides()
    {
        // Fetch all rides or rides with a specific status
        if ($this->status == 'all') {
            $this->rides = Ride::all();
        } else {
            $this->rides = Ride::where('status', $this->status)->get();
        }

        // Initialize selectedStatus array
        foreach ($this->rides as $ride) {
            $this->selectedStatus[$ride->id] = $ride->status;
        }
    }

    public function changeStatus($rideId, $status)
    {
        // Update the status of the ride
        $ride = Ride::find($rideId);
        if ($ride) {
            $ride->update(['status' => $status]);
            $this->emit('refreshRides'); // Trigger the refreshRides method in the parent component
        }
    }

    public function updateKilometerPrice()
    {
        // Update the price per kilometer in the settings
        $setting = Setting::find(1);
        if ($setting) {
            $setting->update(['price_per_km' => $this->pricePerKm]);
        }
    }
}
