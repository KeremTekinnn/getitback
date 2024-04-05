<div>
    <form wire:submit.prevent="updateKilometerPrice">
        <label for="kilometerPrice">Kilometer Price:</label>
        <input wire:model="pricePerKm" id="kilometerPrice" type="number" step="0.01" min="0">
        <button type="submit">Update</button>
    </form>

    <label for="statusFilter">Filter by status:</label>
    <select wire:model="status" id="statusFilter" wire:change="fetchRides">
        <option value="all">All</option>
        <option value="pending">Pending</option>
        <option value="underway">Underway</option>
        <option value="done">Done</option>
    </select>

    <table>
        <thead>
        <tr>
            <th>User</th>
            <th>Pickup</th>
            <th>Dropoff</th>
            <th>Date</th>
            <th>Distance</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($this->rides as $ride)
            <tr>
                <td>{{ $ride->user->name }}</td>
                <td>{{ $ride->pickup }}</td>
                <td>{{ $ride->dropoff }}</td>
                <td>{{ $ride->date }}</td>
                <td>{{ $ride->distance }}</td>
                <td>{{ $ride->cost }}</td>
                <td>{{ $ride->status }}</td>
                <td>
                    <select wire:change="changeStatus({{ $ride->id }}, $event.target.value)">
                        <option value="pending" @if($ride->status == 'Pending') selected @endif>Pending</option>
                        <option value="underway" @if($ride->status == 'Underway') selected @endif>Underway</option>
                        <option value="done" @if($ride->status == 'Done') selected @endif>Done</option>
                    </select>
                </td>
                <td>
                    <!-- Add any action buttons here if needed -->
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No results found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
