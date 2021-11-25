<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light" style="box-shadow: 0px 0px 5px #888888;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="{{ route('home') }}">
            <img src="{{ url('/') }}/assets/logo.png" width="75" style="margin: -10px 0px -10px 0px;"/>
        </a>

        <a class="btn btn-success nav-link mx-1" href="{{ route('sellingAuctions') }}" role="button">
            <div class="d-flex align-items-center">
            <span class="material-icons-outlined">shopping_cart</span>
            <span class="d-none d-lg-block">Chci koupit</span>
            </div>
        </a>

        <a class="btn btn-warning nav-link mx-1" href="{{ route('buyingAuctions') }}" role="button">
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
                <a href="{{ route('profile') }}" class="dropdown-item"><h4>{{ Auth::user()->name }}</h4></a>
                @if(Auth::user()->is_admin())
                    <a href="{{ route('userList') }}" class="dropdown-item">Sprava uživatelů</a>
                @endif

                @if(Auth::user()->is_auctioneer() || Auth::user()->is_admin())
                    <a href="{{ route('auctionApproval') }}" class="dropdown-item">Neschválené aukce</a>
                @endif

                @if(Auth::user()->is_admin() || Auth::user()->is_auctioneer())
                    <a href="{{ route('approvedByYou') }}" class="dropdown-item">Aukce schvalené mnou</a>
                @endif

                <a href="{{ route('userAuctions') }}" class="dropdown-item">Moje nabídky</a>
                <a class="dropdown-item" href=" {{ route('userTakesPartIn') }} ">Registrované aukce</a>
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
        <div class="d-lg-none collapse navbar-collapse pt-4" id="navbarSupportedContent">
        @guest
            <div class="list-group d-lg-none">
                @if (Route::has('login'))
                    <a class="list-group-item list-group-item-action" href="{{ route('login') }}">Přihlásit</a>
                @endif

                @if (Route::has('register'))
                    <a class="list-group-item list-group-item-action" href="{{ route('register') }}">Registrovat</a>
                @endif
            </div>
        @else
            <a href="{{ route('profile') }}" class="dropdown-item"><h4 class="d-lg-none" >{{ Auth::user()->name }}</h4></a>

            <div class="list-group d-lg-none">
                @if(Auth::user()->is_admin())
                    <a href="{{ route('userList') }}" class="list-group-item list-group-item-action"><b>Sprava uživatelů</b></a>
                @endif

                <a href="{{ route('userAuctions') }}" class="list-group-item list-group-item-action">Moje nabídky</a>

                @if(Auth::user()->is_auctioneer() || Auth::user()->is_admin())
                    <a href="{{ route('auctionApproval') }}" class="list-group-item list-group-item-action"><b>Neschválené aukce</b></a>
                @endif

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
