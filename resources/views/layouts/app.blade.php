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

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <div class="d-flex" id="wrapper">
                @auth
                    <!-- Sidebar -->
                    <div class="bg-light border-right" id="sidebar-wrapper">
                        <div class="sidebar-heading">
                        {{ config('app.name', 'Laravel') }}
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action bg-light">Productos</a>
                            <a href="{{ route('registrations.index') }}" class="list-group-item list-group-item-action bg-light">Inscripciones</a>
                            <a href="{{ route('users.index', ['role' => 'customer']) }}" class="list-group-item list-group-item-action bg-light">Usuarios</a>
                            <a href="{{ route('partners.index') }}" class="list-group-item list-group-item-action bg-light">Cabeceras</a>
                        </div>
                    </div>
                    <!-- /#sidebar-wrapper -->
                @endauth

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                        <div class="container-fluid">
                            @auth
                                <button class="btn btn-primary" id="menu-toggle">
                                    <i class="fa fa-bars"></i>
                                </button>
                            @endauth

                            <a class="navbar-brand" href="{{ url('/') }}">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto">

                                </ul>

                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">
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
                                        <li class="nav-item dropdown">
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
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </nav>

                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('menu-toggle').onclick = function() {
                var element = document.getElementById('wrapper');
                element.classList.toggle('toggled');
            }
        </script>
        @yield('scripts')
    </body>
</html>
