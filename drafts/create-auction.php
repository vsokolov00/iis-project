
<!doctype html>
<html lang="cz">

<body>
  <div class="container">
    <form>
      <div class="d-sm-flex  flex-md-row my-1">
        <div class="col">
          <label for="name">Název</label>
          <input type="text" class="form-control" id="name">
        </div>
        <div class="col">
          <label for="startPrice">Počáteční cena</label>
          <input type="text" class="form-control" id="stratPrice">
        </div>
      </div>
      <div class="d-sm-flex  flex-sm-row my-1">
        <div class="col">
          <label for="auctionStart">Začátek aukce</label>
          <input type="datetime-local" class="form-control" id="auctionStart"/>
        </div>
        <div class="col">
          <label for="auctionEnd">Konec aukce</label>
          <input type="datetime-local" class="form-control" id="auctionEnd"/>
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
          </div>
        </div>
        <div class="col">
          <label for="rules">Pravidla aukce</label>
          <div class="d-flex choose-from-2" id="rules">
            <div class="col chooseBtn label-green text-center " id="open" onclick="chooseFromClicked('#open', '#closed')">Otevřená</div>
            <div class="col chooseBtn label-yellow text-center chooseBtn-not-checked" id="closed" onclick="chooseFromClicked('#closed', '#open')">Uzavřená</div>
          </div>
        </div>
        <div class="col">
          <label for="bidRange">Rozsah příhozů</label>
          <div class="d-flex" id="bidRange">
            <input type="number" class="form-control mr-1" id="stratRange">
            <input type="number" class="form-control" id="endRange">
          </div>
        </div>
      </div>
      
    </form>
  </div>
</body>

</html>