@extends('layouts.app')

@section('content')
<div class="container page login-page">
    <div class="jumbotron-fluid">

        <h1 id="login-header">Přihlášení</h1>

        <form method="POST" id="loginForm" name="loginForm">
            @csrf
            <div class="input-group col-lg-5 col-xs-5">
                <div class="login">
                    <input id="login-username" type="email" class="form-control @error('email') is-invalid @enderror text-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mailová adresa">
                        <i class="material-icons form-icon">person</i>
                    </input>
                </div>
                <b class="err-label" id="invalid-username">
                    @error('email')
                        {{ $message }}
                    @enderror
                </b>
            </div>

            <div class="input-group col-lg-5 col-xs-5">
                <div class="login">
                    <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror text-input" name="password" required autocomplete="current-password" placeholder="Heslo">
                        <a href="#" class="form-icon"><i id="eyeIcon" class="material-icons">visibility_off</i></a>
                    </input>
                </div>
                <b class="err-label" id="invalid-password">
                    @error('password')
                        {{ $message }}
                    @enderror
                </b>
            </div>

            <div class="input-group col-7 col-lg-4">
                <button type="submit" class="btn btn-primary button-yellow btn-group-lg btn-block">Přihlásit</button>
            </div>

            <div class="col-lg-5 col-xs-5">
                @if (Route::has('register'))
                    <center>
                        <a href="{{ route('register') }}">Nemáte účet? Registrujte se u nás!</a>
                    </center>
                @endif
            </div>
        </form>
    </div>
</div>
</div>

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
    });
</script>
@endsection
