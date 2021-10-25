@extends('layouts.app')

@section('content')
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
                        
                    </div>
                </form>
            </div>
        </div>
@endsection
