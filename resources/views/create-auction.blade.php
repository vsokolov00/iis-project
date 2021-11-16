@extends('layouts.app')

@section('content')
  <div class="container">
    <form action="{{ route('newAuction') }}" method="POST" files="true" enctype="multipart/form-data">
      @csrf
      <div class="d-sm-flex  flex-md-row my-1">
        <div class="col">
          <label for="name">Název</label>
          <input type="text" class="form-control" id="name" name="name" required oninvalid="this.setCustomValidity('Vyplnite toto policko')">
        </div>
        <div class="col">
          <label for="startPrice">Počáteční cena</label>
          <input type="text" class="form-control" id="stratPrice" name="stratPrice" required oninvalid="this.setCustomValidity('Vyplnite toto policko')">
        </div>
      </div>

      <div class="d-sm-flex  flex-md-row my-1">
        <div class="col">
          <label for="name">Popis</label>
          <input type="text" class="form-control" id="description" name="description" required oninvalid="this.setCustomValidity('Vyplnite toto policko')">
        </div>
      </div>

      <div class="d-sm-flex  flex-md-row my-1">
        <div class="col">
          <label for="closingPrice">Uzaviraci cena</label>
          <input type="text" class="form-control" id="closingPrice" name="closingPrice">
        </div>
      </div>

      <div class="d-sm-flex  flex-sm-row my-1">
        <div class="col">
          <label for="auctionStart">Začátek aukce</label>
          <input type="datetime-local" class="form-control" id="auctionStart" name="auctionStart" required oninvalid="this.setCustomValidity('Vyplnite toto policko')"/>
        </div>
        <div class="col">
          <label for="auctionEnd">Konec aukce</label>
          <input type="datetime-local" class="form-control" id="auctionEnd" name="auctionEnd"/>
        </div>
          <script>
            function getToday(){
              var date = new Date();
              var dateTime = date.toISOString().slice(0, 16);
            return dateTime;
            }
            $(document).ready(function (){
              $("#auctionStart").val(getToday());
              $("#auctionStart").attr("min", getToday());
              $("#auctionEnd").val(getToday());
              $("#auctionEnd").attr("min", getToday());
            })
          </script>
      </div>
      <div class="d-sm-flex  flex-sm-row my-1">
        <div class="col">
          <label for="type">Typ aukce</label>
          <div class="d-flex choose-from-2" id="type">
            <div class="col chooseBtn label-green text-center chooseBtn-not-checked" id="buy" onclick="chooseFromClicked('#buy', '#sell')">Nákup</div>
            <div class="col chooseBtn label-yellow text-center" id="sell" onclick="chooseFromClicked('#sell', '#buy')">Prodej</div>
            <!--EASIER FOR THE MODEL, SOLVE LATER-->
            <input type="radio" name="is_selling" id="buy" value="0" />
            <label for="buy">Nakup</label>
            <input type="radio" checked="checked" name="is_selling" id="sell" value="1" />
            <label for="sell">Prodej</label>
            <!---->
          </div>
        </div>
        <div class="col">
          <label for="rules">Pravidla aukce</label>
          <div class="d-flex choose-from-2" id="rules">
            <div class="col chooseBtn label-green text-center " id="open" onclick="chooseFromClicked('#open', '#closed')">Otevřená</div>
            <div class="col chooseBtn label-yellow text-center chooseBtn-not-checked" id="closed" onclick="chooseFromClicked('#closed', '#open')">Uzavřená</div>
            <!--EASIER FOR THE MODEL, SOLVE LATER-->
            <input type="radio" checked="checked" name="is_open" id="open" value="1" />
            <label for="open">Otevřená</label>
            <input type="radio" name="is_open" id="closed" value="0" />
            <label for="closed">Uzavřená</label>
            <!---->
          </div>
        </div>
        <div class="col">
          <label for="bidRange">Rozsah příhozů</label>
          <div class="d-flex" id="bidRange">
            <input type="number" class="form-control mr-1" id="stratRange">
            <input type="number" class="form-control" id="endRange">
          </div>
        </div>

        <!--TODO styles!!!-->
        <input type="file" accept="image/*" name="image">

        <input type="submit" value="Vytvorit">

      </div>
  </div>
@endsection
