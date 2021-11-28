@extends('layouts.app')

@section('content')
  <div class="container">
    <form action="{{ route('newAuction') }}" method="POST" files="true" enctype="multipart/form-data">
      @csrf
      <div class="d-md-flex align-items-center flex-lg-row my-1 mb-5">
        <div class="col">
          <div class="d-flex justify-content-center align-items-end ">
            <img id="previewImg" src="../../img/empty.png" class="previewImg img-fluid"/>

            <label for="image" class="addImgBtn">
            <span class="material-icons-outlined md-36">add</span>
            </label>
            <input class="d-none" type="file" accept="image/*" name="image" id="image" onchange="showPreview(this)">
          </div> 

        </div>
        <div class="col">
            <label for="name">Název</label>
            <input type="text" class="form-control" id="name" name="name" required>

            <label for="name">Popis</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
      </div>

      <div class="d-md-flex  flex-lg-row my-1">
        <div class="col">
          <label for="startPrice">Počáteční cena</label>
          <input type="number" class="form-control startPrice" id="stratPrice" name="stratPrice" min="0" required onchange="defaultMaxBid()">
          <div id="startPriceError" class="invalid-feedback"></div>
        </div>
        <div class="col">
          <label for="startPrice">Konečná cena</label>
          <input type="number" class="form-control closingPrice" id="closingPrice" name="closingPrice" min="0">
          <div id="closingPriceError"  class="invalid-feedback"></div>
        </div>
      </div>

      <div class="d-md-flex  flex-lg-row my-1 mb-5">
        <div class="col bidRange">
          <label for="bidRange">Rozsah příhozů</label>
          <div class="d-flex bid-range" id="bidRange">
              <input type="number" class="form-control mr-1 bid_min" id="bid_min" name="bid_min" value="1" required>
              <input type="number" class="form-control bid_max" id="bid_max" name="bid_max"  required>
          </div>    
          <div id="bidError"  class="invalid-feedback"></div>
        </div>
        <div class="col"></div>
      </div>

      <div class="d-md-flex  flex-lg-row my-1 mb-5">
        <div class="col">
          <label for="auctionStart">Začátek aukce</label>
          <input type="datetime-local" class="form-control auctionStart" id="auctionStart" name="auctionStart" required/>
          <div id="auctionStartError" class="invalid-feedback"></div>
        </div>
        <div class="col">
          <label for="auctionEnd">Konec aukce</label>
          <input type="datetime-local" class="form-control auctionEnd" id="auctionEnd" name="auctionEnd" required/>
          <div id="auctionEndError" class="invalid-feedback"></div>
        </div>
          <script>
            function getToday(){
              var date = new Date();
              date.setHours( date.getHours() + 1 );
              var dateTime = date.toISOString().slice(0, 16);
              return dateTime;
            }
            function get7daysAfterToday(){
              var date = new Date();
              date.setHours( date.getHours() + 1 );
              date.setDate(date.getDate() + 7);
              var dateTime = date.toISOString().slice(0, 16);
              return dateTime;
            }
            $(document).ready(function (){
              $("#auctionStart").val(getToday());
              $("#auctionStart").attr("min", getToday());
              $("#auctionEnd").val(get7daysAfterToday());
              $("#auctionEnd").attr("min", getToday());
            })
          </script>
      </div>

      <div class="d-md-flex  flex-lg-row my-1 mb-5">
        <div class="col">
          <label for="type">Typ aukce</label>
          <div class="d-flex choose-from-2" id="type">
            <div class="col chooseBtn label-green text-center chooseBtn-not-checked" id="btnbuy" onclick="chooseFromClicked('#btnbuy', '#btnsell')">
              Nákup
              <input type="radio" name="is_selling" id="buy" class="d-none buy" value="0"  />
            </div>
            <div class="col chooseBtn label-yellow text-center" id="btnsell" onclick="chooseFromClicked('#btnsell', '#btnbuy')">
              Prodej
              <input type="radio" checked="checked" name="is_selling" id="sell" class="d-none" value="1" />
            </div>
          </div>
        </div>
        <div class="col">
          <label for="rules">Pravidla aukce</label>
          <div class="d-flex choose-from-2" id="rules">
            <div class="col chooseBtn label-green text-center " id="btnopen" onclick="chooseFromClicked('#btnopen', '#btnclosed')">
              Otevřená
              <input type="radio" checked="checked" name="is_open" id="open" class="d-none" value="1" />
            </div>
            <div class="col chooseBtn label-yellow text-center chooseBtn-not-checked" id="btnclosed" onclick="chooseFromClicked('#btnclosed', '#btnopen')">
              Uzavřená
              <input type="radio" name="is_open" id="closed" class="d-none closed" value="0" />
            </div>
          </div>
        </div>
        </div>      
        <div class="col">
          <input type="submit" value="Odeslat ke schválení" class="btn btn-success btn-block mt-2" id="submitAuction">
        </div>
      
  </div>
@endsection
