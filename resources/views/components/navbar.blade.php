<nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="container">
        <a class="navbar-brand mr-auto" href="{{ route('home') }}">
            <img src="{{ url('/') }}/assets/logo.png" width="50"/>
        </a>

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
        <span id="account_circle" class="material-icons md-48 nav-link " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">account_circle</span>
        <div class="dropdown-menu dropdown-menu-right">
            @guest
                @if (Route::has('login'))
                    <a class="dropdown-item" href="{{ route('login') }}">Přihlásit</a>
                @endif

                @if (Route::has('register'))
                    <a class="dropdown-item" href="{{ route('register') }}">Registrovat</a>
                @endif
            @else
                <h4 class="dropdown-item">{{ Auth::user()->name }}</h4>
                <a class="dropdown-item" href="#">Moje nabídky</a>
                <a class="dropdown-item" href="#">Registrované aukce</a>
                <a class="dropdown-item" href="#">Nastavení</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit()">
                            Odhlásit se
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <div class="dropdown-divider"></div>
            @endguest
        </div>
        </div>

        <div class=" nav-link mx-1 d-lg-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        </div>
        <div class="d-lg-none collapse navbar-collapse" id="navbarSupportedContent">
        @guest
            <div class="list-group d-lg-none">
                @if (Route::has('login'))
                    <a class="list-group-item list-group-item-action" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif

                @if (Route::has('register'))
                    <a class="list-group-item list-group-item-action" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            </div>
        @else
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
        @endguest
        </div>
    </div>
</nav>
