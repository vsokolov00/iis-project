@extends('layouts.app')

@section('content')
<div class="container page register-page">
    <div class="jumbotron-fluid">
        <h1 id="register-header">Profil</h1>

        <form method="POST" id="change-username">
            @csrf
            <div class="m-3">
                <h5>Jméno<h5>
                <div class="d-flex align-items-center">
                    <div class="col-sm-9 col-md-7 col-lg-4">
                        <input id="username" type="text" name="username" class="form-control" value="{{ Auth::user()->name }}" readonly/>
                    </div>
                    <button type="submit" class="rounded border d-flex p-1">
                        <i id="change-username-submit" class="material-icons md-24 color-warning">edit</i>
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" id="change-email">
            @csrf
            <div class="m-3">
                <h5>E-mailová adresa</h5>
                <div class="d-flex align-items-center">
                    <div class="col-sm-9 col-md-7 col-lg-4">
                        <input id="email" type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly/>
                    </div>
                    <button type="submit" class="rounded border d-flex p-1">
                        <i id="change-email-submit" class="material-icons md-24 color-warning">edit</i>
                    </button>
                </div>
            </div>
        </form>

        <div class="m-3">
            <h5>Heslo</h5>
            <div class="col-lg-3 col-xs-3">
                <button type="button" data-toggle="collapse" id="change-password-collapse" data-target="#new-password" class="btn btn-warning m-2 btn-sm">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="material-icons md-18">edit</i>
                        <div class="ml-2 align-middle text-center">Změnit heslo</div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    @if(($password ?? "") == "changed")
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Vaše heslo bylo úspěšně změněno.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="collapse @if(isset($password) && $password != 'changed') show @endif" id="new-password">
        <div class="background-grey m-3 rounded p-2 m-2 p-md-5 p-md-5">
            <h5>Změna hesla</h5>
            <div class="d-flex flex-column" id="editProfileForm">
                <form method="POST" class="d-flex flex-column align-items-center">
                    @csrf
                    <div class="input-group col-lg-5 col-xs-5">
                        <b>Nové heslo</b>
                        <div class="register">
                            <input id="password" type="password" class="form-control text-input" name="new_password" value="{{ old('new_password') }}" required autocomplete="new-password" placeholder="Vaše nové heslo">
                                <a class="form-icon" data-toggle="popover" data-trigger="click" title="Doporučený formát hesla" data-placement="bottom"
                                    data-content="Heslo musí být alespoň 6 znaků dlouhé a obsahovat přinejmenším alespoň jednu číslici. Doporučujeme použít heslo o délce alespoň 8 znaků s použitím speciálních znaků a číslic.">
                                    <i class="material-icons">password</i>
                                </a>
                            </input>
                        </div>
                        <b class="err-label" id="invalid-password">
                        </b>
                    </div>

                    <div class="input-group col-lg-5 col-xs-5">
                        <b>Ověření hesla</b>
                        <div class="register">
                            <input id="password-confirm" type="password" class="form-control text-input" name="password_confirm" value="{{ old('password_confirm') }}" required autocomplete="new_password" placeholder="Nové heslo znovu">
                                <i class="material-icons form-icon">password</i>
                            </input>
                        </div>
                        <b class="err-label" id="nonmatching-passwords"></b>
                    </div>

                    <div class="input-group col-lg-5 col-xs-5">
                        <b>Staré heslo</b>
                        <div class="login">
                            <input id="login-password" type="password" class="form-control text-input" name="old_password" value="{{ old('old_password') }}" required autocomplete="current_password" placeholder="Staré heslo">
                                <a class="form-icon"><i id="eyeIcon" class="material-icons">visibility_off</i></a>
                            </input>
                        </div>
                        <b class="err-label" id="invalid-password">
                        </b>
                    </div>

                    <div class="input-group col-lg-4 col-xs-4">
                        <button class="btn btn-success" type="submit">Uložit</button>
                    </div>
                </form>

                @if(isset($password))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" id="passwordAlert" role="alert">
                        @if($password == 'invalid')
                            Nesprávně zadané staré heslo.
                        @elseif($password == 'nonmatching')
                            Zadaná nová hesla nejsou stejná.
                        @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <script>
                        window.scrollTo(0, document.getElementById('passwordAlert').offsetTop);
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
