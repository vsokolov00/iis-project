<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!-- Default font link. -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

<!-- Navbar styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/auction_style.css') }}">
<!-- Register form styles -->
<link href="{{ asset('css/register.css') }}" rel="stylesheet">

@if(isset($price) && isset($lastBid))
    <div class="yellow-text">{{ $price }}</div>
    <div class="green-text">{{ $lastBid }}</div>
@else if(isset($price))
    <div class="yellow-text">{{ $price }}</div>
@endif
