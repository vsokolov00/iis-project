$(document).ready(function() {   
    $('[data-toggle="popover"]').popover();   

    $("#username").focusout(VerifyUsername);
    $("#email").focusout(VerifyMail);
    $("#password").on("input", function() {
        VerifyPasswords();
        if($("#password-reenter").val() == "")
            $("#nonmatching-passwords").text("");
    });
    $("#password-reenter").on("input", VerifyPasswords);

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

        if($("#password").val() != $("#password-reenter").val())
            $("#nonmatching-passwords").text("Zadaná hesla nejsou shodná.");
        else
            $("#nonmatching-passwords").text("");
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
