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
        $this->pricePerKm = Setting::find(1)->price_per_km;
        $this->fetchRides();
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }

    public function fetchRides()
    {
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
        $ride = Ride::find($rideId);
        if ($ride) {
            $ride->update(['status' => $status]);
            $this->emit('refreshRides'); // Trigger the refreshRides method in the parent component
        }
    }

    public function updateKilometerPrice()
    {
        $setting = Setting::find(1);
        if ($setting) {
            $setting->update(['price_per_km' => $this->pricePerKm]);
        }
    }
}
