<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/auction_style.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                                    
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <a class="btn btn-success nav-link mx-1" href="#" role="button">
                        <div class="d-flex align-items-center">
                        <span class="material-icons-outlined">shopping_cart</span>
                        <span class="d-none d-lg-block">Chci koupit</span>
                        </div>
                    </a>

                    <a class="btn btn-warning nav-link mx-1" href="#" role="button">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined">sell</span>
                        <span class="d-none d-lg-block">Chci prodat</span>
                    </div>
                    </a>
                    <div class="nav-item dropdown d-none d-lg-block">
                    <span class="material-icons md-48 nav-link " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">account_circle</span>
                    <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>-->
                    <div class="dropdown-menu dropdown-menu-right" ><!--aria-labelledby="navbarDropdown">-->
                        <h4 class="dropdown-item">{{ Auth::user()->name }}</h4>
                        <a class="dropdown-item" href="#">Moje nabídky</a>
                        <a class="dropdown-item" href="#">Registrované aukce</a>
                        <a class="dropdown-item" href="#">Nastavení</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                Odhlásit se
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </div>
                    </div>
                    
                    <div class=" nav-link mx-1 d-lg-none">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    </div>
                    <div class="d-lg-none collapse navbar-collapse" id="navbarSupportedContent">
                    <h4 class="d-lg-none" >{{ Auth::user()->name }}</h4>
                    <div class="list-group d-lg-none">
                        <a href="#" class="list-group-item list-group-item-action">Moje nabídky</a>
                        <a href="#" class="list-group-item list-group-item-action">Registrované aukce</a>
                        <a href="#" class="list-group-item list-group-item-action">Nastavení</a>
                        <a class="list-group-item list-group-item-action" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                Odhlásit se
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    </div>  
                    <!-- <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li> -->
                @endguest
                    
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
