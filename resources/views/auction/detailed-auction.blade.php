@extends('layouts.app')

@section('content')

<div class="background-grey pt-4">
    <div class="container">
      <h1>{{$auction->auctionItem->item_name}}</h1>
      <div class="d-md-flex flex-md-row two-columns align-items-stretch py-3">
        <div class="img-auction-detail mb-1 d-flex align-items-center justify-content-center">
          <img class="img-fluid" src="{{ route('image.displayImage',$auction->auctionItem->image) }}" alt="Položka aukce">
        </div>
        <div class="auction-detail-panel">
          @if ($auction->is_open)
            <h5>Otevřená aukce</h5>
            <h4 id="startTime"></h4>
           
            <h5 id="priceName"></h5>
          @else
            <h5>Uzavřená aukce</h5>
            <h4 id="startTime"></h4>
            <h5>Počáteční cena:</h5>
          @endif
          <div class="d-flex align-items-top flex-wrap" id="detailPrice">
          </div>
          <div class="d-flex">
            @auth
              @if ($registered !== 2)
                @if ($registered == 1)
                  <input type="number"  class="form-control font-size-25" value="{{ $auction->bid_min }}" min="{{$auction->bid_min}}" max="{{$auction->bid_max}}" id="inputBid" disabled/>
                  <button class="btn btn-success ml-3" href="#" id="btnBid" role="button" onclick="makeBid('{{$auction->is_open}}')" disabled>
                    <div class="d-flex align-items-center">
                      <span class="material-icons-outlined md-36">done</span>
                      Přihodit
                    </div>
                  </button>
                @elseif ($registered == 3)
                  <input type="number"  class="form-control font-size-25" value="{{ $default_bid }}" min="{{$auction->bid_min}}" max="{{$auction->bid_max}}"  disabled/>
                  <button class="btn btn-success ml-3" href="#"  role="button" onclick="makeBid('{{$auction->is_open}}')" disabled>
                    <div class="d-flex align-items-center">
                      <span class="material-icons-outlined md-36">done</span>
                      Přihodit
                    </div>
                  </button>
                @elseif ($registered == 4)
                  <h4 class="mt-3" style="color:#FF0000">Bylo Vám zakázáno zúčastnit se aukce.</h4>
                @else
                  <a class="btn btn-success btn-block btn-lg" href="{{ route('registerToAuction', ['id' => $auction->id]) }}" id="btnRegister" role="button" style="display: none;">Registrovat</a>
                @endif
              @endif
            @else
              <a class="btn btn-success btn-block btn-lg" href="{{ route('login') }}" id="btnRegister" role="button" style="display: none;">Registrovat</a>
            @endauth
          </div>
          <div id="wrongRangeError" class="invalid-feedback" ></div>
          @if ($registered === 3)
            <h4 class="mt-3" style="color:#42AA1F">Váš příhoz byl zaznamenán.</h4>
          @endif 
          @isset($winner)
              @if($auction->winner == Auth::user()->id)
                <h4 id="winnerName" class="mt-2" style="color: #42AA1F">Jste vítězem!</h4>
              @else
                <h4 id="winnerName" class="mt-2" style="color: #42AA1F">Vítěz: {{ $winner->name }}</h4>
                <h5  style="color: #42AA1F">Kontakt: {{ $winner->email }}</h5>
              @endif
          @endisset($winner)
          @isset($auction->results_approved)
            @if($auction->results_approved === 0)
              <h4 class="mt-2" style="color: red"> Výsledek aukce byl zamítnut</h4>
            @endif
          @endisset
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
