<div class="table-container text-center">
    <h1>My Rides</h1>
    <div>
        <label for="status">Filter by status:</label>
        <select wire:model="status" id="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="underway">Underway</option>
            <option value="done">Done</option>
            <!-- Add more options as needed -->
        </select>
    </div>

    <table class="table table-striped table-responsive-lg table-responsive-sm">
        <thead>
        <tr>
            <th>Pickup</th>
            <th>Dropoff</th>
            <th>Date</th>
            <th>Distance</th>
            <th>Price</th>
            <th>Status</th>
            <th>Invoice</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($rides as $ride)
            <tr>
                <td>{{ $ride->pickup }}</td>
                <td>{{ $ride->dropoff }}</td>
                <td>{{ $ride->date }}</td>
                <td>{{ $ride->distance }}km</td>
                <td>€{{ $ride->cost }}</td>
                <td>
                    @switch($ride->status)
                        @case('Done')
                            <span class="badge text-bg-success">Done</span>
                            @break

                        @case('Pending')
                            <span class="badge text-bg-danger">Pending</span>
                            @break

                        @case('Underway')
                            <span class="badge text-bg-warning">Underway</span>
                            @break

                        @default
                            <span class="badge bg-secondary">{{ $ride->status }}</span>
                    @endswitch
                </td>
                <td>
                    <a href="{{ route('invoice.download', $ride->id) }}" class="btn btn-primary">
                        <i class="bi bi-download"></i>
                    </a>
                    <a href="{{ route('invoice.email', $ride->id) }}" class="btn btn-secondary">
                        <i class="bi bi-envelope"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No results found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $rides->links('vendor.livewire.bootstrap') }}
    </div>
</div>
