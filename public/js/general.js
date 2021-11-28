jQuery(function() {
    //
    // Nastavení vyskakovacích oken a nápovědy
    //
    if($("[data-toggle=popover]").length)
        $("[data-toggle=popover]").popover();

    if($("[data-toggle=tooltip]").length)
        $("[data-toggle=tooltip]").tooltip();

    //
    // Třídy se speciální funkčností
    //
    $('.dont-propagate').on('click', function(event) { event.stopPropagation(); });

    //
    // Přihlašovací formulář
    //
    $("#eyeIcon").on("click", function (event) {
        if($("#login-password").attr("type") == "password")
        {
            $("#login-password").attr("type", "text");
            $("#eyeIcon").text("visibility");
        }
        else
        {
            $("#login-password").attr("type", "password");
            $("#eyeIcon").text("visibility_off");
        }
    });

    $("#loginForm").on("submit", function(event) {
        if($("#login-username").val() == "" || $("#login-password").val() == "")
        {
            $("#error-message").html("<br><div class='alert alert-danger alert-dismissible'>" +
                                    "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
                                    "Nebylo zadáno uživatelské jméno nebo heslo.</div>");
            event.preventDefault();
        }
    });

    $("#login-username").on("focusout", function() {
        if($("#login-username").val() == "")
            $("#invalid-username").text("Nebyla zadána e-mailová adresa.");
        else
            $("#invalid-username").text("");
    });

    $("#login-password").on("focusout", function() {
        if($("#login-password").val() == "")
            $("#invalid-password").text("Nebylo zadáno heslo.");
        else
            $("#invalid-password").text("");
    });

    //
    // Registrační formulář
    //
    $("#username").on("focusout", VerifyUsername);
    $("#email").on("focusout", VerifyMail);
    $("#password").on("input", function() {
        VerifyPasswords();
        if($("#password-confirm").val() == "")
            $("#nonmatching-passwords").text("");
    });

    $("#password-confirm").on("input", VerifyPasswords);

    $("#registerForm").on("submit", function(event) {
        if(!IsUsernameValid($("#username").val()) || !IsMailValid($("#email").val()) ||
            GetPasswordStrenght($("#password").val()) < 0 || $("#password-confirm").val() != $("#password").val())
        {
            event.preventDefault();
            VerifyUsername();
            VerifyMail();
            VerifyPasswords();

            $("#error-message").html("<br><div class='alert alert-danger alert-dismissible'>" +
                                    "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
                                    "Zadané údaje jsou nesprávné, pro více informací klikněte na ikonu vedle zadávacího pole.</div>");
        }
    });

    //
    // Správa uživatelského profilu
    //
    $("#editProfileForm").on("submit", function(event) {
        if(GetPasswordStrenght($("#password").val()) < 0 || $("#password-confirm").val() != $("#password").val())
        {
            event.preventDefault();
            VerifyPasswords();
        }
    });

    $("#change-username").on("submit", function(action) {
        if($("#change-username-submit").text() == "edit")
        {
            disableAllEditInputs();
            $("#new-password").removeClass("show");
            $("#change-username-submit").text("done");
            $("#change-username-submit").removeClass("color-warning");
            $("#change-username-submit").addClass("color-success");
            $("#username").prop("readonly", false);
            document.getElementById("username").focus();
            action.preventDefault();
        }
    });

    $("#change-email").on("submit", function(action) {
        if($("#change-email-submit").text() == "edit")
        {
            disableAllEditInputs();
            $("#new-password").removeClass("show");
            $("#change-email-submit").text("done");
            $("#change-email-submit").removeClass("color-warning");
            $("#change-email-submit").addClass("color-success");
            $("#email").prop("readonly", false);
            document.getElementById("email").focus();
            action.preventDefault();
        }
    })

    $("#change-password-collapse").on("click", function() {
        disableAllEditInputs();
    });

    //
    // Správa všech uživatelů
    //
    $('.type-toggle').on('click', function(event) {
        event.preventDefault();

        var caller = $(event.target);
        var id = caller.data('userid');
        var role = caller.data('role');

        var formattedData = role == "auctioneer" ? { userId: id, isAuctioneer: 1 } : { userId: id, isAdmin: 1 }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            data: formattedData,
            success: function (_, _, xhr) {
                if(xhr.status == 200)
                {
                    var targetId = event.target.id;

                    $("#" + targetId).prop('checked', !$("#" + targetId).is(':checked'));
                    var isChecked = !$("#" + targetId).is(':checked');
                    if(isChecked) {
                      $("#" + targetId).prop('checked', false);
                      return;
                    }

                    var user_id = $("#" + targetId).attr("id").match(/\d+/)[0];
                    var group = "input[type=checkbox][id^='"+user_id+"r']";
                    $(group).prop('checked', false);
                    $("#" + targetId).prop('checked', true);

                    if(targetId.slice(-1) == 'm')
                        $("#" + targetId.slice(0, targetId.length - 2)).prop('checked', true);
                    else
                        $("#" + targetId + "-m").prop('checked', true);
                }
            }
        });
    });

    $('.deleteUser').on('click', function(event) {
        if(!confirm("Opravdu chce smazat uživatele?"))
            event.preventDefault();
    });

    //
    // Správa aukcí
    //
    $('.approve-decline-user').on('click', function(event) {
        event.preventDefault();
        var caller = $(event.target);
        var id = caller.data('userid');
        var username = caller.data('username');
        var auction = caller.data('auctionid');

        result = confirm("Chcete trvale odebrat uživatele " + username + " z účasti v aukci?");

        if (result) {
            var formattedData = { userId: id, auctionId: auction, response: 0 }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                data: formattedData,
                success: function (_, _, xhr) {
                    if(xhr.status == 200)
                    {

                    }
                    var parent = caller.parent().parent();
                    parent.css("display", "none");
                },
                error: function() {
                    alert('Není možné provest tuto akci.')
                }
            });
        }
    });

    $('#deleteButton').on('click', function(event) {
        if (!confirm("Opravdu chcete smazat tuto aukci?"))
            return;
        else
        {
            var url = $(event.target).data('target');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax(url, {
                type: "DELETE",
                data: { "id": $("#id").val(), "deleteItem": true },
                success: function (msg, _, xhr) {
                    location.reload();
                }
            });
        }
    });

    $('.auction-result-submit').on('click', function(event) {
        event.preventDefault();
        var caller = $(event.target);
        var id = caller.data('auctionid');
        var response = caller.data('response');
        var route = caller.data('target');

        if(response == 1) {
            result = confirm("Chcete schvalit výsledky této aukcí? ");
        } else {
            result = confirm("Chcete zamitnout výsledky této aukcí? ");
        }

        if (result) {
            var formattedData = { auctionId: id, response: response }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax( route, {
                type: "POST",
                data: formattedData,
                success: function (_, _, xhr) {
                    var parent = caller.parent();
                    parent.css("display", "none");

                    if (response == 0)
                        $("#auction-result").hide();
                },
                error: function() {
                    alert('Není možné provest tuto akci.')
                }
            });
        }
    });
});

function invalidateAuction(target, id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(target, {
        type: "POST",
        data: { "id" : id },
        success: function (_, _, xhr) {
            if(xhr.status == 200)
            {
                $("#detail-" + id).hide();
                $("#detail-small-" + id).hide();
                $("#header-" + id).hide();
                $("#header-small-" + id).hide();
            }
        }
    });
}

function formatTime(time){
    var dateTime = new Date(time);
    var day = dateTime.getDate();
    var month = parseInt(dateTime.getMonth())+parseInt(1);
    var time = dateTime.toTimeString().slice(0,5);

    if(day < 10)
        day = "0"+day;

    if(month < 10)
        month = "0"+month;

    return dateTime.getFullYear()+"-"+month+"-"+day+"T"+time;
}

//
// Správa modálních oken
//
function openModal(id, img, name, description, sprice, eprice, isapproved, minbid, maxbid, stime, etime, isopen, issell) {
    $("#id").val(id);
    $("#previewImg").attr("src", img);
    $("#edit-name").val(name);
    $("#edit-description").val(description);
    $("#edit-startPrice").val(sprice);
    $("#edit-endPrice").val(eprice);
    $("#edit-startRange").val(minbid);
    $("#edit-endRange").val(maxbid);
    $("#edit-auctionStart").val(formatTime(stime));
    $("#edit-auctionEnd").val(formatTime(etime));

    if(issell == "1")
        chooseFromClicked('#btnsell', '#btnbuy');
    else
        chooseFromClicked('#btnbuy', '#btnsell');

    if(isopen == "1")
        chooseFromClicked('#btnopen', '#btnclosed');
    else
        chooseFromClicked('#btnclosed', '#btnopen');

    if (isapproved != null && isapproved == 1)
        $(".inv_after_approved").hide();
    else
        $(".inv_after_approved").show();

    $("#editModal").modal('show');
};

function openUserModal(id, name, email) {
    $("#byAdmin").val(1);
    $("#id").val(id);
    $("#edit-name").val(name);
    $("#edit-email").val(email);

    $("#editUserModal").modal('show');
};

//
// Správa uživatelů
//
function disableAllEditInputs()
{
    $("#change-email-submit").text("edit");
    $("#change-email-submit").removeClass("color-success");
    $("#change-email-submit").removeClass("color-warning");
    $("#change-email-submit").addClass("color-warning");
    $("#email").prop("readonly", true);

    $("#change-username-submit").text("edit");
    $("#change-username-submit").removeClass("color-success");
    $("#change-username-submit").removeClass("color-warning");
    $("#change-username-submit").addClass("color-warning");
    $("#ne-username-submit").addClass("disabled");
    $("#username").prop("readonly", true);
}

function IsMailValid(email)
{
    const mailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return mailRegex.test(String(email).toLowerCase());
}

function IsUsernameValid(username)
{
    return username.length < 50 && username.length > 3;
}

function GetPasswordStrenght(password)
{
    var specialCharacterRegex = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    var numberRegex = /\d/;

    if(password.length >= 8 && specialCharacterRegex.test(String(password)) && numberRegex.test(String(password)))
        return 1;
    else if(password.length >= 6 && numberRegex.test(String(password)))
        return 0;
    else
        return -1;
}

function VerifyUsername()
{
    $("#invalid-username").text(IsUsernameValid($("#username").val()) ? "" :
        $("#username").val() == "" ?
            "Nebylo zadáno uživatelské jméno." : "Formát uživatelského jména není platný. (viz. ikona vpravo)");
}

function VerifyMail()
{
    $("#invalid-email").text(IsMailValid($("#email").val()) ? "" :
        $("#email").val() == "" ?
            "E-mailová adresa je povinný údaj." : "Tento formát e-mailové adresy není správný.");
}

function VerifyPasswords()
{
    var passwordStrength = GetPasswordStrenght($("#password").val());

    if($("#password").val() == "")
    {
        if($("#invalid-password").hasClass("warn-label"))
            $("#invalid-password").removeClass("warn-label");
        if(!$("#invalid-password").hasClass("err-label"))
            $("#invalid-password").addClass("err-label");
        $("#invalid-password").text("Nebylo zadáno heslo.");
    }
    else if(passwordStrength < 0)
    {
        if($("#invalid-password").hasClass("warn-label"))
            $("#invalid-password").removeClass("warn-label");
        if(!$("#invalid-password").hasClass("err-label"))
            $("#invalid-password").addClass("err-label");
        $("#invalid-password").text("Heslo není dostatečně silné.");
    }
    else if(passwordStrength == 0)
    {
        if($("#invalid-password").hasClass("err-label"))
            $("#invalid-password").removeClass("err-label");
        if(!$("#invalid-password").hasClass("warn-label"))
            $("#invalid-password").addClass("warn-label");
        $("#invalid-password").text("Heslo splňuje minimální požadavky, přesto doporučujeme zvolit silnější variantu.");
    }
    else
        $("#invalid-password").text("");

    if($("#password").val() != $("#password-confirm").val())
        $("#nonmatching-passwords").text("Zadaná hesla nejsou shodná.");
    else
        $("#nonmatching-passwords").text("");
}

function showDetail(id){
    $("#detail-background").removeClass("detail-view-hide");
    $("#detail-container").removeClass("detail-view-hide");
    $("#detail-form").removeClass("detail-view-hide");
}

function hideDetail(id){
    $("#detail-background").addClass("detail-view-hide");
    $("#detail-container").addClass("detail-view-hide");
    $("#detail-form").addClass("detail-view-hide");
}

var timeInterval = 0;
var syncTimeTimer = 0;
var priceInterval = 0;
var syncPriceTimer = 0;
var auctionStartTime;
var auctionEndTime;
var auctionId;
var serverTime = new Date();
function startTimer(startTime, endTime, id){
    auctionStartTime = startTime;
    auctionEndTime = endTime;
    syncTimeTimer = setTimeout(updateTime, timeInterval);
    auctionId = id;
    updatePrice();
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
        timeInterval = 300;
        }else{
        var minutesLeft = Math.ceil(Math.abs((endTime.getTime() - startTime.getTime())/(60*1000)));
        $("#startTime").html(textToShow+" za: " + minutesLeft + " min"); //Zobrazí kolik zbývá minut
        timeInterval = 1000;
        }
    }else{
        $("#startTime").html(textToShow+": "+dateToShow);
    timeInterval = 60*1000;//1 minuta
    }
}

var updateTime = function(){
    $.get("/auction/time", function(data, status){
        serverTime = new Date(data);

        if(auctionStartTime.getTime() > serverTime.getTime()){
        timeCounter(auctionStartTime, serverTime, "start")
        $("#priceName").html("Počáteční cena:");
        $("#inputBid").prop("disabled", true);
        $("#btnBid").prop("disabled", true);
        $("#btnRegister").css("display", "block");
        priceInterval = 360000;
        }else{
        timeCounter(serverTime, auctionEndTime, "end");
        $("#priceName").html("Aktuální cena:");
        $("#inputBid").prop("disabled", false);
        $("#btnBid").prop("disabled", false);
        priceInterval = 5000;
        updatePrice();
        if(auctionEndTime.getTime() < serverTime.getTime()){
            $("#startTime").html("Aukce skončila.");
            $("#priceName").html("Konečná cena:");
            $("#inputBid").prop("disabled", true);
            $("#btnBid").prop("disabled", true);
            clearTimeout(syncTimeTimer);
            return;
        }
            $("#btnRegister").css("display", "block");
        }
        syncTimeTimer = setTimeout(updateTime, timeInterval);
    });
}

var updatePrice = function(){
    $.get("/auction/"+auctionId+"/status/price", function(data, status){
        $('#detailPrice').html(data);
        clearTimeout(syncPriceTimer);
        if(auctionEndTime.getTime() > serverTime.getTime()){
        syncPriceTimer = setTimeout(updatePrice, priceInterval);
        }

    });
}

function makeBid(is_open, is_selling) {
    var max = document.getElementById("inputBid").max;
    var min = document.getElementById("inputBid").min;
    var value = document.getElementById("inputBid").value;
    if(is_open == 1){
        if(Number(min)>Number(value)||Number(value)>Number(max)){
            document.getElementById("wrongRangeError").innerHTML = "Výše příhozu musí být v rozsahu "+min+"-"+max;
            document.getElementById("inputBid").classList.add("is-invalid");
            $("#wrongRangeError").css("display", "block");
            return;
        }else{
            document.getElementById("wrongRangeError").innerHTML ="";
            document.getElementById("inputBid").classList.remove("is-invalid");
        }
    }else{
        if(Number(value) <= 0){
            document.getElementById("wrongRangeError").innerHTML = "Výše příhozu musí být vyšší než 0";
            document.getElementById("inputBid").classList.add("is-invalid");
            $("#wrongRangeError").css("display", "block");
        return;
        }else{
            document.getElementById("wrongRangeError").innerHTML ="";
            document.getElementById("inputBid").classList.remove("is-invalid");
        }
    }
    if(!is_selling){
        var actualPrice = parseInt($("#price").text());
        if(actualPrice-value < 0){
            document.getElementById("wrongRangeError").innerHTML = "Výše příhožu nesmí převyšovat aktuální cenu.";
            document.getElementById("inputBid").classList.add("is-invalid");
            $("#wrongRangeError").css("display", "block");
            return;
        }else{
            document.getElementById("wrongRangeError").innerHTML ="";
            document.getElementById("inputBid").classList.remove("is-invalid");
        }
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post("/auction/bid", {id: auctionId, bid: value}, function(data, status){
        if (status == "success" && is_open == 0){
            $("#inputBid").prop("disabled", true);
            $("#btnBid").prop("disabled", true);
            $(".auction-detail-panel").append('<h4 class="mt-3" style="color:#42AA1F">Váš příhoz byl zaznamenán.</h4>');
        }
    });
    updatePrice();
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

function chooseFromClicked(activeId, inactiveId){
    $(inactiveId).addClass("chooseBtn-not-checked");
    $(activeId).removeClass("chooseBtn-not-checked");
    $('#'+inactiveId.slice(4)).prop("checked", false);
    $('#'+activeId.slice(4)).prop("checked", true);

    if($(".closed").is(":checked")){
        $(".bidRange").css("display", "none");
        $(".bid_min").prop("required", false);
        $(".bid_max").prop("required", false);
    }else{
        $(".bidRange").css("display", "block");
        $(".bid_min").prop("required", true);
        $(".bid_max").prop("required", true);
    }
}

function chooseFromClickedRoles(activeRole, inactiveRole1, inactiveRole2){
    $(inactiveRole1).addClass("chooseBtn-not-checked");
    $(inactiveRole2).addClass("chooseBtn-not-checked");
    $(activeRole).removeClass("chooseBtn-not-checked");
    $('#'+inactiveRole1.slice(4)).prop("checked", false);
    $('#'+inactiveRole2.slice(4)).prop("checked", false);
    $('#'+activeRole.slice(4)).prop("checked", true);
}

function leftScroll(listId){
    $(listId).animate({
        scrollLeft: "-=260px"
    },800);
}

function rightScroll(listId){
    $(listId).animate({
        scrollLeft: "+=260px"
    },800);
}

function showPreview(input){
    var file = $("input[type=file]").get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }

        reader.readAsDataURL(file);
    }
}

$("#submitAuction").click(function(event){
$(".startPrice").removeClass("is-invalid");
$("#startPriceError").empty();
$(".closingPrice").removeClass("is-invalid");
$("#closingPriceError").empty();
$(".bid_min").removeClass("is-invalid");
$(".bid_max").removeClass("is-invalid");
$("#bidError").empty();
$(".auctionStart").removeClass("is-invalid");
$("#auctionStartError").empty();
$(".auctionEnd").removeClass("is-invalid");
$("#auctionEndError").empty();

if($(".buy").is(":checked")){
    if(parseInt($(".startPrice").val()) <= parseInt($(".closingPrice").val())){
        $("#startPriceError").html("Konečná cena musí být nižší, než počáteční.");
        $(".startPrice").addClass("is-invalid");
        $(".closingPrice").addClass("is-invalid");
        event.preventDefault();
    }
}else{
    if(parseInt($(".startPrice").val()) >= parseInt($(".closingPrice").val())){
        $("#startPriceError").html("Konečná cena musí být vyšší, než počáteční.");
        $(".startPrice").addClass("is-invalid");
        $(".closingPrice").addClass("is-invalid");
        event.preventDefault();
    }
}

if(parseInt($(".startPrice").val()) < 1){
    $("#startPriceError").html("Počáteční cena musí být alespoň 1.");
    $(".startPrice").addClass("is-invalid");
    event.preventDefault();
}

if(parseInt($(".closingPrice").val()) < 1){
    $("#closingPriceError").html("Konečná cena musí být alespoň 1.");
    $(".closingPrice").addClass("is-invalid");
    event.preventDefault();
}

if(parseInt($(".bid_min").val()) >= parseInt($(".bid_max").val())){
    $("#bidError").html("Maximální výše příhozu musí být vyšší než minimální.");
    $("#bidError").css("display", "block");
    $(".bid_min").addClass("is-invalid");
    $(".bid_max").addClass("is-invalid");
    event.preventDefault();
}

if(parseInt($(".bid_min").val()) < 1){
    $("#bidError").html("Výše příhozu musí být vyšší než 0.");
    $("#bidError").css("display", "block");
    $(".bid_min").addClass("is-invalid");
    event.preventDefault();
}

if(parseInt($(".bid_max").val()) < 1){
    $("#bidError").html("Výše příhozu musí být vyšší než 0.");
    $(".bid_max").addClass("is-invalid");
    $("#bidError").css("display", "block");
    event.preventDefault();
}

if(Date.parse($(".auctionStart").val()) >= Date.parse($(".auctionEnd").val())){
    $("#auctionStartError").html("Aukce nesmí skončit dříve, než začne.");
    $(".auctionStart").addClass("is-invalid");
    $(".auctionEnd").addClass("is-invalid");
    event.preventDefault();
}

if(Date.parse($(".auctionStart").val()) < new Date()){
    $("#auctionStartError").html("Aukce nemůže začít v minulosti.");
    $(".auctionStart").addClass("is-invalid");
    event.preventDefault();
}

if(Date.parse($(".auctionEnd").val()) < new Date()){
    $("#auctionEndError").html("Aukce nemůže začít v minulosti.");
    $(".auctionEnd").addClass("is-invalid");
    event.preventDefault();
}
});

$(".decline-user").tooltip();
$("#btnBid").tooltip();

function defaultMaxBid(){
    var startPrice = $("#stratPrice").val();
    var maxBid = $("#bid_max").val();

    if(maxBid == ""){
        if(startPrice > 100){
        $("#bid_max").val(Math.round(startPrice/10));
        }else{
        $("#bid_max").val(startPrice);
        }
    }
}
