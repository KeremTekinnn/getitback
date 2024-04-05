@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('ride.store') }}" class="w-full max-w-xs mx-auto">
        @csrf
    <!-- Input field for pickup address with autocomplete -->
        <div class="mb-4">
            <label for="pickupInput" class="block mb-1">Pickup Address</label>
            <input type="text" id="pickupInput" name="pickup" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter pickup address">
            @error('pickup')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- Input field for delivery address with autocomplete -->
        <div class="mb-4">
            <label for="deliveryInput" class="block mb-1">Delivery Address</label>
            <input type="text" id="deliveryInput" name="dropoff" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter delivery address">
            @error('dropoff')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- Input field for date -->
        <div class="mb-4">
            <label for="dateInput" class="block mb-1">Date</label>
            <input type="date" id="dateInput" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('date')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- Input field to display distance -->
        <div class="mb-4">
            <label for="distanceInput" class="block mb-1">Distance</label>
            <div class="flex">
                <input type="text" id="distanceInput" name="distance" class="shadow appearance-none border rounded w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Distance" readonly>
                <div class="self-center ml-2">km</div>
            </div>
            @error('distance')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- Input field to display cost -->
        <div class="mb-4">
            <label for="costInput" class="block mb-1">Cost</label>
            <div class="flex">
                <input type="text" id="costInput" name="cost" class="shadow appearance-none border rounded w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cost" readonly>
                <div class="self-center ml-2">€</div>
            </div>
            @error('cost')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" id="bookButton">Book</button>
    </form>
    <script>
        // Initialize Google Places Autocomplete on the input fields
        let pickupInput = document.getElementById('pickupInput');
        let deliveryInput = document.getElementById('deliveryInput');
        let distanceInput = document.getElementById('distanceInput');
        let costInput = document.getElementById('costInput');
        let dateInput = document.getElementById('dateInput');

        let options = {
            types: ['address'], // Include both geocode and address types
            componentRestrictions: { country: 'nl' } // Set country code if needed
        };

        let pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, options);
        let deliveryAutocomplete = new google.maps.places.Autocomplete(deliveryInput, options);

        // Customize the appearance and behavior of the autocomplete dropdown
        pickupAutocomplete.setFields(['address_components', 'formatted_address', 'geometry']);
        deliveryAutocomplete.setFields(['address_components', 'formatted_address', 'geometry']);

        // Add event listeners to update distance and duration when addresses are selected
        pickupAutocomplete.addListener('place_changed', calculateDistance);
        deliveryAutocomplete.addListener('place_changed', calculateDistance);


        // Function to calculate distance and duration
        function calculateDistance() {
            let pickupPlace = pickupAutocomplete.getPlace();
            let deliveryPlace = deliveryAutocomplete.getPlace();

            if (!pickupPlace.geometry || !deliveryPlace.geometry) {
                // One or both addresses are invalid
                return;
            }

            let service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [pickupPlace.geometry.location],
                destinations: [deliveryPlace.geometry.location],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC
            }, function (response, status) {
                if (status === google.maps.DistanceMatrixStatus.OK) {
                    let distance = response.rows[0].elements[0].distance.value / 1000; // Convert meters to kilometers
                    let cost = distance * {{ $pricePerKm }};
                    costInput.value = cost.toFixed(2);
                    distanceInput.value = distance.toFixed(2);
                } else {
                    alert('Error: Unable to calculate distance and duration.');
                }
            });
        }

    </script>

@endsection