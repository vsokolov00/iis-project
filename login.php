<!doctype html>
<html lang="cz">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Google icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- General project style -->
        <link rel="stylesheet" href="./general.css">        
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Default font link. -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <title>Aukce</title>
    </head>

    <body>
        <div class="container page">
            <div class="jumbotron-fluid">

                <h1 id="login-header">Přihlášení</h1>

                <form method="POST" id="loginForm" name="loginForm">

                    <div class="input-group col-xs-4">
                        <div class="login">
                            <input id="username" name="username" type="text" class="form-control text-input" placeholder="Uživatelské jméno">
                                <i class="material-icons form-icon">person</i>
                            </input>
                        </div>
                        <b class="err-label" id="invalid-username"></b>
                    </div>

                    <div class="input-group col-xs-4">
                        <div class="login">
                            <input id="password" name="password" type="password" class="form-control text-input" placeholder="Heslo">
                                <a href="#" class="form-icon"><i id="eyeIcon" class="material-icons">visibility_off</i></a>
                            </input>
                        </div>
                        <b class="err-label" id="invalid-password"></b>
                    </div>
                    
                    <div class="input-group col-xs-3">
                        <button type="submit" class="btn btn-primary button-yellow btn-group-lg btn-block">Přihlásit</button>
                    </div>

                    <div class='col-xs-6' id="error-message">
                        <?php
                            require 'auth.php';
                            
                            if(!$AUTHORIZED)
                            {
                                if(isset($_POST["username"]) && isset($_POST["password"]))
                                {
                                    if($_POST["password"] == "password")
                                    {
                                        $_SESSION["username"] = $_POST["username"];
                                        $AUTHORIZED = true;
                                        $USERNAME = isset($_POST["username"]);
                                        returnToSender();
                                    }
                                    else
                                        echo "<br><div class='alert alert-danger alert-dismissible'>
                                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                Neplatné uživatelské jméno nebo heslo.
                                            </div>";
                                }
                            }
                            else
                                returnToSender();
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <style>
        .login { display: flex; align-items: center; justify-content: center;}
        .input-group { margin: 10px; }
        #loginForm { display: flex; align-items: center; align-self: center; flex-direction: column;}
        #login-header { margin-bottom: 0.5em; }
        .text-input { border-radius: 7px; min-width: 200px; padding-right: 35px !important; }
        .page { margin-top: 1em; }
    </style>

    <script>
        $(document).ready(function() {   
            $("#eyeIcon").click(function (event) {
                if($("#password").attr("type") == "password")
                {
                    $("#password").attr("type", "text");
                    $("#eyeIcon").text("visibility");
                }
                else
                {
                    $("#password").attr("type", "password");
                    $("#eyeIcon").text("visibility_off");
                }
            });

            $("#loginForm").submit(function(event) {
                if($("#username").val() == "" || $("#password").val() == "")
                {
                    $("#error-message").html("<br><div class='alert alert-danger alert-dismissible'>" + 
                                            "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" + 
                                            "Nebylo zadáno uživatelské jméno nebo heslo.</div>");
                    event.preventDefault();
                }
            });

            $("#username").focusout(function() {
                if($("#username").val() == "")
                    $("#invalid-username").text("Nebylo zadáno uživatelské jméno.");
                else
                    $("#invalid-username").text("");
            });

            $("#password").focusout(function() {
                if($("#password").val() == "")
                    $("#invalid-password").text("Nebylo zadáno heslo.");
                else
                    $("#invalid-username").text("");
            });
        });
    </script>
</html>