@extends('layouts.app')

@section('content')

<div class="background-grey">
    <div class="container">
      <h1>{{$auction->auctionItem->item_name}}{{$registered}}</h1>
      <div class="d-md-flex flex-md-row two-columns align-items-stretch py-3">
        <div class="img-auction-detail mb-1 d-flex align-items-center justify-content-center">
          <img class="img-fluid" src="{{ asset('storage/images/'.$auction->auctionItem->image) }}" alt="Položka aukce">
        </div>
        <div class="auction-detail-panel">
          <h4 id="startTime"></h4>
          <h5 id="priceName"></h5>
          <div class="d-flex align-items-top flex-wrap" id="detailPrice">
          </div>
          <div class="d-flex">
            @auth
              @if ($registered !== 2)
                @if ($registered == 1)
                  <input type="number"  class="form-control font-size-25" value="10" min="'.$bidMin.'" max="'.$bidMax.'" id="inputBid" oninput="checkBidRange()" disabled/>
                  <button class="btn btn-success ml-3" href="#" id="btnBid" role="button" onclick="makeBid()" disabled>
                    <div class="d-flex align-items-center">
                      <span class="material-icons-outlined md-36">done</span>
                      Přihodit
                    </div>  
                  </button>
                @else
                  <a class="btn btn-success btn-block btn-lg" href="{{ route('registerToAuction', ['id' => $auction->id]) }}" id="btnRegister" role="button">Registrovat</a> 
                @endif
              @endif
            @else
              <a class="btn btn-success btn-block btn-lg" href="{{ route('login') }}" id="btnRegister" role="button">Registrovat</a> 
            @endauth         
          </div>
          <span id="wrongRangeSpan" ></span>
        </div>
      </div>

    </div>
    <div class="auction-description">
      <div class="container ">
        {{$auction->auctionItem->description}}
      </div>
    </div>
    </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type= "text/javascript">
    $(document).ready(function() {
      startTimer(new Date("{{$auction->start_time}}"), new Date("{{$auction->time_limit}}"), "{{$auction->id}}");  
    });
  </script>
@endsection('content')