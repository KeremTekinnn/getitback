<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-body {
            margin-bottom: 20px;
        }

        .invoice-footer {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="invoice-header">
    <h1>Invoice</h1>
</div>

<div class="invoice-body">
    <h2>Invoice Details</h2>
    <p>Pickup: {{ $ride->pickup }}</p>
    <p>Dropoff: {{ $ride->dropoff }}</p>
    <p>Date: {{ $ride->date }}</p>
    <p>Distance: {{ $ride->distance }}</p>
    <p>Status: {{ $ride->status }}</p>
    <p>Price: &euro;{{ $ride->cost }}</p>

</div>

<div class="invoice-footer">
    <p>Thank you for using our service!</p>
</div>
</body>
</html>
