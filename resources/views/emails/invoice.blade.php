<x-mail::message>
# Invoice for Your Ride

Here are the details of your ride:

- Pickup: {{ $ride->pickup }}
- Dropoff: {{ $ride->dropoff }}
- Date: {{ $ride->date }}
- Distance: {{ $ride->distance }} km
- Price: €{{ $invoice->amount }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
