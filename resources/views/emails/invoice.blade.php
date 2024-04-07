<x-mail::message>
# Invoice for Your Ride

Here are the details of your ride:

- Pickup: {{ $invoice->ride->pickup }}
- Dropoff: {{ $invoice->ride->dropoff }}
- Date: {{ $invoice->ride->date }}
- Distance: {{ $invoice->ride->pickup }} km
- Price: €{{ $invoice->amount }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
