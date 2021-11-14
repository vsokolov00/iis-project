@extends('layouts.app')

@section('content')
<div class="container page register-page">
    <div class="jumbotron-fluid">
        <h1 id="register-header">Profil</h1>

        <form method="POST" id="change-username">
            <div class="m-3">
                <h5>Uživatelské jméno<h5>
                <div class="d-flex align-items-center">
                    <div class="col-sm-9 col-md-7 col-lg-4">
                        <input id="username" type="text" class="form-control" value="{{ Auth::user()->name }}" disabled/>
                    </div>
                    <button class="rounded border d-flex p-1">
                        <i id="change-username-submit" class="material-icons md-24 color-warning">edit</i>
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" id="change-email">
            <div class="m-3">
                <h5>E-mailová adresa</h5>
                <div class="d-flex align-items-center">
                    <div class="col-sm-9 col-md-7 col-lg-4">
                        <input id="email" type="email" class="form-control" value="{{ Auth::user()->email }}" disabled/>
                    </div>
                    <button class="rounded border d-flex p-1">
                        <i id="change-email-submit" class="material-icons md-24 color-warning">edit</i>
                    </button>
                </div>
            </div>
        </form>

        <div class="m-3">
            <h5>Heslo</h5>
            <div class="col-lg-3 col-xs-3">
                <button type="button" data-toggle="collapse" data-target="#new-password" class="btn btn-warning m-2 btn-sm">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="material-icons md-18">edit</i>
                        <div class="ml-2 align-middle text-center">Změnit heslo</div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="collapse" id="new-password">
        <div class="background-grey m-5 rounded p-5">
            <h5>Změna hesla</h5>
            <div class="d-flex flex-column">
                <form method="POST" class="d-flex flex-column align-items-center">
                    <div class="input-group col-lg-5 col-xs-5">
                        <b>Nové heslo</b>
                        <div class="register">
                            <input id="password" type="password" class="form-control text-input" name="password" required autocomplete="new-password" placeholder="Vaše nové heslo">
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
                            <input id="password-confirm" type="password" class="form-control text-input" name="password_confirmation" required autocomplete="new-password" placeholder="Nové heslo znovu">
                                <i class="material-icons form-icon">password</i>
                            </input>
                        </div>
                        <b class="err-label" id="nonmatching-passwords"></b>
                    </div>

                    <div class="input-group col-lg-5 col-xs-5">
                        <b>Staré heslo</b>
                        <div class="login">
                            <input id="login-password" type="password" class="form-control text-input" name="password" required autocomplete="current-password" placeholder="Staré heslo">
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
            </div>
        </div>
    </div>
</div>
@endsection
