@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (Session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if (Session('warning'))
<div class="alert alert-warning">
    {{ session('warning') }}
</div>
@endif

@if (Session('info'))
<div class="alert alert-info">
    {{ session('warning') }}
</div>
@endif


<!-- 
<div class="alert alert-{{ $type }} alert-dismissible">
    {{ $slot }}
</div>

<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

-->