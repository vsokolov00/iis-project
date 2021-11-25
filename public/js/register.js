jQuery(function() {
    $("[data-toggle=popover]").popover();

    //LOGIN FORM
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

    // REGISTER FORM
    $("#username").on("focusout", VerifyUsername);
    $("#email").on("focusout", VerifyMail);
    $("#password").on("input", function() {
        VerifyPasswords();
        if($("#password-confirm").val() == "")
            $("#nonmatching-passwords").text("");
    });
    $("#password-confirm").on("input", VerifyPasswords);

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

    // EDIT FORM
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
});


$('.approve-decline-user').on('click', function(event) {
    event.preventDefault();
    var caller = $(event.target);
    var id = caller.data('userid');
    var username = caller.data('username');
    var auction = caller.data('auctionid');

    result = confirm("Chcete trvale odebrat uživatele " + username + " z účasti v aukci?");
    
    if (result) {
        var formattedData = { userId: id, auctionId: auction, response: 0 }
        console.log(formattedData);
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

$('.auction-result-submit').on('click', function(event) {
    event.preventDefault();
    var caller = $(event.target);
    var id = caller.data('auctionid');
    var response = caller.data('response');
    var route = caller.data('target');

    result = confirm("Chcete schvalit výsledky této aukcí? ");
    
    if (result) {
        var formattedData = { auctionId: id, response: response }
        console.log(formattedData);
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
                // var results = document.getElementById('auction-result');
                // results.style.visibility = 'visible';

            }, 
            error: function() {
                alert('Není možné provest tuto akci.')
            }
        });
    }
});



function openModal(id, img, name, description, sprice, isapproved, minbid, maxbid, stime, etime, isopen, issell) {
    $("#id").val(id);
    $("#previewImg").attr("src", img);
    $("#edit-name").val(name);
    $("#edit-description").val(description);
    $("#edit-startPrice").val(sprice);
    $("#edit-startRange").val(minbid);
    $("#edit-endRange").val(maxbid);
    $("#edit-auctionStart").val((new Date(stime)).toISOString().slice(0, 16));
    $("#edit-auctionEnd").val((new Date(etime)).toISOString().slice(0, 16));

    if(issell == "1")
        chooseFromClicked('#btnsell', '#btnbuy');
    else
        chooseFromClicked('#btnbuy', '#btnsell');

    if(isopen == "1")
        chooseFromClicked('#btnopen', '#btnclosed');
    else
        chooseFromClicked('#btnclosed', '#btnopen');
        
    if (isapproved != null && isapproved == 1) {
        var editButtons = document.getElementsByClassName('inv_after_approved');
        for (var i = 0; i < editButtons.length; i ++) {
            editButtons[i].style.display = 'none';
        }
    } else {
        var editButtons = document.getElementsByClassName('inv_after_approved');
        for (var i = 0; i < editButtons.length; i ++) {
            editButtons[i].style.display = 'inline';
        }
    }

    $("#editModal").modal('show');
};

function openUserModal(id, name, email) {
    $("#byAdmin").val(1);
    $("#id").val(id);
    $("#edit-name").val(name);
    $("#edit-email").val(email);

    $("#editUserModal").modal('show');
};

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
