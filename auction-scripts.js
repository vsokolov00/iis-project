  function showDetail(id){
    $("#detail-background").removeClass("detail-view-hide");
    $("#detail-container").removeClass("detail-view-hide");
    $("#detail-form").removeClass("detail-view-hide");
    //$("#userAuctions").load("user-list.php");
  }

  function hideDetail(id){
    $("#detail-background").addClass("detail-view-hide");
    $("#detail-container").addClass("detail-view-hide");
    $("#detail-form").addClass("detail-view-hide");
  }
  $(".material-switch").on("click", function(event){
    event.stopPropagation();
  });

    var interval = 0;
    var timer = 0;
    var auctionStartTime;
    var auctionEndTime; 
  function startTimer(startTime, endTime){
    auctionStartTime = startTime;
    auctionEndTime = endTime;
    timer = setTimeout(updateTime, interval);    
  }

  function timeCounter(startTime, endTime, start_end){
    var textToShow;
    var dateToShow;
    if(start_end == "start"){
      textToShow = "Začátek";
      dateToShow = startTime.toLocaleString().slice(0, startTime.toLocaleString().length - 3);
    }else{
      textToShow = "Konec";
      dateToShow = endTime.toLocaleString().slice(0, endTime.toLocaleString().length - 3);
    }

    if(Math.abs((endTime.getTime() - startTime.getTime())) < (60*60*1000)){
      if(Math.abs(endTime.getTime() - startTime.getTime()) < 60*1000){
        var secondsLeft = Math.ceil(Math.abs((endTime.getTime() - startTime.getTime())/1000));
        $("#startTime").html(textToShow+" za: " + secondsLeft + "s"); //Zobrazí kolik zbývá sekund
        interval = 300;
      }else{
        var minutesLeft = Math.ceil(Math.abs((endTime.getTime() - startTime.getTime())/(60*1000)));
        $("#startTime").html(textToShow+" za: " + minutesLeft + " min"); //Zobrazí kolik zbývá sekund
        interval = 1000;
      }
    }else{
      $("#startTime").html(textToShow+": "+dateToShow);
    interval = 60*1000;//1 minuta
    }
  
  }
  var updateTime = function(){
    $.get("server-time.php", function(data, status){
      var serverTime = new Date(data);

      if(auctionStartTime.getTime() > serverTime.getTime()){
        timeCounter(auctionStartTime, serverTime, "start")
        $("#priceName").html("Počáteční cena:");
        $("#inputBid").prop("disabled", true);
        $("#btnBid").prop("disabled", true);
      }else{
        timeCounter(serverTime, auctionEndTime, "end");
        $("#priceName").html("Aktuální cena:"); 
        $("#inputBid").prop("disabled", false);
        $("#btnBid").prop("disabled", false);
        if(auctionEndTime.getTime() < serverTime.getTime()){
          $("#startTime").html("Aukce skončila.");
          $("#priceName").html("Konečná cena:");
          $("#inputBid").prop("disabled", true);
          $("#btnBid").prop("disabled", true);
          clearTimeout(timer);
          return;
        }
      }
      timer = setTimeout(updateTime, interval);
    }); 
  }

  function checkBidRange() {
    var max = document.getElementById("inputBid").max;
    var min = document.getElementById("inputBid").min;
    var value = document.getElementById("inputBid").value;
    if(Number(min)>Number(value)||Number(value)>Number(max)){
      document.getElementById("wrongRangeSpan").innerHTML = "Výše příhozu musí být v rozsahu "+min+"-"+max;
      document.getElementById("inputBid").classList.add("is-invalid");
    }else{
      document.getElementById("wrongRangeSpan").innerHTML ="";
      document.getElementById("inputBid").classList.remove("is-invalid");
    }
  }

  function checkboxChange(checkboxId, auctionTypeLabelId){
    if($(checkboxId).is(":checked")){
      $(auctionTypeLabelId).html("Prodej");
      $(auctionTypeLabelId).addClass("label-yellow");
      $(auctionTypeLabelId).removeClass("label-green");
    }else{
      $(auctionTypeLabelId).html("Nákup");
      $(auctionTypeLabelId).addClass("label-green");
      $(auctionTypeLabelId).removeClass("label-yellow");
    } 
  }