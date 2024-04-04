<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use App\Models\Ride;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class RidesTable extends Component
{
    use WithPagination;

    public $status = '';

    public function render()
    {
        $rides = Ride::where('user_id', Auth::id())
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate(10); // Change 10 to the number of items you want to display per page

        return view('livewire.client.rides-table', [
            'rides' => $rides,
        ]);
    }

    public function filterByStatus($status)
    {
        $this->status = $status;
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }
}
