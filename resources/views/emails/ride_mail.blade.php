<x-mail::message>
# Ride Booked Successfully

Your ride has been booked successfully. Here are the details:

- Pickup: {{ $ride->pickup }}
- Dropoff: {{ $ride->dropoff }}
- Date: {{ $ride->date }}
- Distance: {{ $ride->distance }} km
- Price: €{{ $ride->cost }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
