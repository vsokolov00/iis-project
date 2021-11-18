@extends('layouts.app')

@section('content')
<div class="background-grey">
<div class="container"> 
    <h1>{{ $auction->auctionItem->item_name }}</h1>
    <div class="d-md-flex flex-md-row two-columns align-items-stretch py-3">
        <div class="img-auction-detail mb-1 d-flex align-items-center">
            <img class="img-fluid" src="{{ asset('storage/images/'.$auction->auctionItem->image) }}" alt="Položka aukce">
        </div>
        <div class="auction-detail-panel">
            <h4 id="startTime">{{ $auction->start_time }}</h4>
            <h5 id="priceName"></h5>
            <div class="d-flex align-items-top flex-wrap">
            <div class="yellow-text">{{ $auction->starting_price }} Kč</div> 
            <div class="green-text">{{ $bid }} Kč</div>
        </div>
        <div class="d-flex">
            @auth
                <form action="{{ route('makeBid', ['id' => "$auction->id"]) }}" method="GET">
                @csrf
                    <input name="bid" type="number"  class="form-control font-size-25" value="10" min="" max="" id="inputBid" oninput="checkBidRange()"/>
                    <button class="btn btn-success ml-3" href="#" id="btnBid" role="button" onclick="checkBidRange()">
                        <div class="d-flex align-items-center">
                            <span class="material-icons-outlined md-36">done</span>
                            Přihodit
                        </div>
                    </button>
                </form>
            @else
                <button class="btn btn-success btn-block btn-lg" href="#" id="btnRegister" role="button">Registrovat</button>
            @endauth          
        </div>
            <span id="wrongRangeSpan" ></span>
        </div>
    </div>
</div>
<div class="auction-description">
    <div class="container ">
        Description
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type= "text/javascript">
$(document).ready(function() {
    startTimer(new Date("2021-11-21T20:25:00+02:00"), new Date("2021-12-22T16:21:00+02:00"));  
});
</script>
@endsection('content')