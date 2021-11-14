<!doctype html>
<html lang="cz">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <!-- Bootstrap dependencies -->
        <!-- Bootstrap JavaScript -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- Google icons -->
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <!-- Default font link. -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <!--Register js script-->
        <script src="{{ asset('js/register.js') }}" defer></script>
        <!--Auction js script-->
        <script src="{{ asset('js/auction-scripts.js') }}" defer></script>
        <!-- Navbar styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/auction_style.css') }}">
        <!-- Register form styles -->
        <link href="{{ asset('css/register.css') }}" rel="stylesheet">

        <title>Aukce</title>
    </head>
<body>
    <div id="app">
        @component('components.navbar')
        @endcomponent
        <main class="py-4 mt-5 pt-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
