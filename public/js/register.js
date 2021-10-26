$(document).ready(function() {   
    //LOGIN FORM
    $("#eyeIcon").click(function (event) {
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
    $("#loginForm").submit(function(event) {
        if($("#login-username").val() == "" || $("#login-password").val() == "")
        {
            $("#error-message").html("<br><div class='alert alert-danger alert-dismissible'>" + 
                                    "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" + 
                                    "Nebylo zadáno uživatelské jméno nebo heslo.</div>");
            event.preventDefault();
        }
    });

    $("#login-username").focusout(function() {
        if($("#login-username").val() == "")
            $("#invalid-username").text("Nebylo zadáno uživatelské jméno.");
        else
            $("#invalid-username").text("");
    });

    $("#login-password").focusout(function() {
        if($("#login-password").val() == "")
            $("#invalid-password").text("Nebylo zadáno heslo.");
        else
            $("#invalid-username").text("");
    });

    //REGISTER FORM
    $('[data-toggle="popover"]').popover();   

    $("#username").focusout(VerifyUsername);
    
    $("#password").on("input", function() {
        VerifyPasswords();
        if($("#password-reenter").val() == "")
            $("#nonmatching-passwords").text("");
    });

    function VerifyUsername()
    {
        if(IsUsernameValid($("#username").val()))
            DoesUsernameExists($("#username").val()).then( response => {
                if(response == "NOT_FREE")
                    $("#invalid-username").text("Účet s daným uživatelským jménem již existuje.");
            });
        
        $("#invalid-username").text(IsUsernameValid($("#username").val()) ? "" : 
            $("#username").val() == "" ?
                "Nebylo zadáno uživatelské jméno." : "Formát uživatelského jména není platný. (viz. ikona vpravo)");
    }


    $("#registerForm").submit(function(event) {
        if(!IsUsernameValid($("#username").val()) || !IsMailValid($("#email").val()) ||
            GetPasswordStrenght($("#password").val()) < 0 || $("#password-reenter").val() != $("#password").val())
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
});
