@if(session('success'))
    <div id="message" class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="message" class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif

<script>
    setTimeout(function() {
        document.getElementById('message').style.display = 'none';
    }, 3000);
</script>
