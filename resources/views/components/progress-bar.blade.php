<div class="progress">
    <div id="step1" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $step == 'ride-create' ? '50' : '100' }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $step == 'ride-create' ? '50%' : '100%' }}">Ride Info</div>
    <div id="step2" class="progress-bar progress-bar-striped progress-bar-animated {{ $step == 'ride-payment' ? 'bg-warning' : '' }}" role="progressbar" aria-valuenow="{{ $step == 'ride-payment' ? '100' : '0' }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $step == 'ride-payment' ? '100%' : '0' }}">Payment</div>
</div>

<script>
    let step1 = document.getElementById('step1');
    let step2 = document.getElementById('step2');

    step1.addEventListener('click', function() {
        window.location.href = '{{ route("ride.create") }}';
    });

    step2.addEventListener('click', function() {
        window.location.href = '{{ route("ride.payment") }}';
    });
</script>
