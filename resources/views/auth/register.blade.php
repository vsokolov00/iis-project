@extends('layouts.app')

@section('content')
<div class="container page register-page">
    <div class="jumbotron-fluid">
        <h1 id="register-header">Registrace</h1>

        <form method="POST" action="{{ route('register') }}" id="registerForm" name="registerForm">
            @csrf
            <div class="input-group col-lg-5 col-xs-5">
                <b>Jméno</b>
                <div class="register">
                    <input id="username" type="text" class="form-control @error('name') is-invalid @enderror text-input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <a href="#" class="form-icon" data-toggle="popover" data-trigger="focus" title="Vaše jméno" data-placement="bottom"
                                data-content="Zvolte své jméno či libovolnou přezdívku o délce minimálně 4 znaky. Toto jméno se bude zobrazovat u Vámi vytvořených aukcí.">
                            <i class="material-icons">person</i>
                        </a>
                    </input>
                </div>
                <b class="err-label" id="invalid-username">
                    @error('name')
                        {{ $message }}
                    @enderror
                </b>
            </div>

            <div class="input-group col-lg-5 col-xs-5">
                <b>E-mailová adresa</b>
                <div class="register">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror text-input" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <a href="#" class="form-icon" data-toggle="popover" data-trigger="focus" title="Vaše E-mailová adresa" data-placement="bottom"
                            data-content="Zadaná adresa bude použita pouze jako možnost obnovy v případě zapomenutého hesla.">
                            <i class="material-icons">alternate_email</i>
                        </a>
                    </input>
                </div>
                <b class="err-label" id="invalid-email">
                    @error('email')
                        {{ $message }}
                    @enderror
                </b>
            </div>

            <div class="input-group col-lg-5 col-xs-5">
            <b>Heslo</b>
                <div class="register">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror text-input" name="password" required autocomplete="new-password">
                        <a href="#" class="form-icon" data-toggle="popover" data-trigger="focus" title="Doporučený formát hesla" data-placement="bottom"
                            data-content="Heslo musí být alespoň 6 znaků dlouhé a obsahovat přinejmenším alespoň jednu číslici. Doporučujeme použít heslo o délce alespoň 8 znaků s použitím speciálních znaků a číslic.">
                            <i class="material-icons">password</i>
                        </a>
                    </input>
                </div>
                <b class="err-label" id="invalid-password">
                    @error('password')
                        {{ $message }}
                    @enderror
                </b>
            </div>

            <div class="input-group col-lg-5 col-xs-5">
                <b>Ověření hesla</b>
                <div class="register">
                    <input id="password-confirm" type="password" class="form-control text-input" name="password_confirmation" required autocomplete="new-password">
                        <i class="material-icons form-icon">password</i>
                    </input>
                </div>
                <b class="err-label" id="nonmatching-passwords"></b>
            </div>

            <div class="input-group col-7 col-lg-4">
                    <button type="submit" class="btn btn-primary button-yellow btn-group-lg btn-block">
                        Registrovat
                    </button>
            </div>

            <div class="col-lg-5 col-xs-5">
                @if (Route::has('login'))
                    <center>
                        <a href="{{ route('login') }}">Máte již u nás účet? Přihlašte se.</a>
                    </center>
                @endif
            </div>

            <div class='col-xs-6' id="error-message"></div>
        </form>
    </div>
</div>
@endsection
