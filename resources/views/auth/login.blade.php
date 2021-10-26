@extends('layouts.registration')

@section('content')
<div class="container page">
    <div class="jumbotron-fluid">
            <h1 id="login-header">Přihlášení</h1>

            <form method="POST" action="{{ route('login') }}" id="loginForm" name="loginForm">
                @csrf

                <div class="input-group col-xs-4">
                    <div class="login">
                        <input id="login-username" type="email" class="form-control @error('email') is-invalid @enderror text-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Uživatelské jméno">
                            <i class="material-icons form-icon">person</i>
                        </input>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <b class="err-label" id="invalid-username"></b>
                    </div>
                </div>

                <div class="input-group col-xs-4">
                    <div class="password">
                        <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror text-input" name="password" required autocomplete="current-password" placeholder="Heslo">
                            <a href="#" class="form-icon"><i id="eyeIcon" class="material-icons">visibility_off</i></a>
                        </input>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <b class="err-label" id="invalid-password"></b>
                    </div>
                </div>
                <!--
                <div class="input-group col-xs-4">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
                -->

                <div class="input-group col-xs-3">
                    <button type="submit" class="btn btn-primary button-yellow btn-group-lg btn-block">
                        Přihlásit
                    </button>
                    <!--
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                    -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
