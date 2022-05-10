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
    @if($domain === 'telva')
    <link href="{{ asset('css/telva.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #D70065;
        }
    </style>
    @elseif($domain === 'marca')
    <link href="{{ asset('css/marca.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #c00;
        }
    </style>
    @elseif($domain === 'diariomedico')
    <link href="{{ asset('css/diariomedico.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #1172B8;
        }
    </style>
    @elseif($domain === 'expansion')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #386AB0;
        }
    </style>
    @else
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #2FC7DD;
        }
    </style>
    @endif
</head>

<body class="{{ $domain }}">
    <div id="app">
        <div class="page-loader">
            <div class="loader text-primary">Cargando...</div>
        </div>
        <div class="d-flex" id="wrapper">
            @auth
            <!-- Sidebar -->
            <div class="bg-primary border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">
                    {{ config('app.name', 'Laravel') }}
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-dashboard"></i>&emsp;Dashboard</a>
                    <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-briefcase"></i>&emsp;Productos</a>
                    @if(Auth::user()->role === 'superadmin')
                    <a href="{{ route('campaigns.index') }}" class="list-group-item list-group-item-action bg-white"><i class="ion ion-ios-analytics" aria-hidden="true"></i>&emsp;Campañas</a>
                    <a href="{{ route('registrations.index') }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-pencil-alt"></i>&emsp;Inscripciones</a>
                    <a href="{{ route('users.index', ['role' => 'customer']) }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-users"></i>&emsp;Usuarios</a>
                    <a href="{{ route('partners.index') }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-bookmark-alt"></i>&emsp;Cabeceras</a>
                    @endif
                    @if(Auth::user()->role === 'financial' || Auth::user()->role === 'superadmin')
                    <a href="{{ route('invoices.index') }}" class="list-group-item list-group-item-action bg-white"><i class="lni lni-revenue"></i>&emsp;Financiero</a>
                    @endif
                </div>
            </div>
            <!-- /#sidebar-wrapper -->
            @endauth

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        @auth
                        <button class="btn btn-link" id="menu-toggle">
                            <i class="ion ion-android-more-vertical"></i>
                        </button>
                        @endauth

                        <a class="navbar-brand" href="{{ url('/') }}">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <img id="partnerLogo" src="" alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <div class="d-flex mx-4 align-content-center">
                                        <i class="lni lni-sun mx-1 mt-3"></i>
                                        <label class="switch">
                                            <input type="checkbox" id="themeSelector" name="themeSelector">
                                            <span class="slider round"></span>
                                        </label>
                                        <i class="lni lni-night mx-1 mt-3"></i>
                                    </div>
                                </li>
                                <!-- Authentication Links -->
                                @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="#" role="button" v-pre>
                                        {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="bottom" title=" {{ __('Logout') }}">
                                        <i class="lni lni-exit"></i>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>



                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>

                <main class="py-4">
                    @yield('content')
                </main>

                @guest
                <footer class="mt-5 mb-5">
                    <div class="container">
                        <div class="row align-self-end">
                            <div class="col-12 col-md-6 text-center text-md-left">
                                &copy;{{ date('Y') }} Unidad Editorial S.A.
                            </div>
                            <div class="col-12 col-md-6">
                                <ul class="list-inline text-center text-sm-right">
                                    @if(isset($checkout))
                                    <li class="list-inline-item"><a class="text-xs-center" target="_blank" href="{{ route('terminos-y-condiciones') }}?c={{ $checkout->id }}">Términos y condiciones</a></li>
                                    @endif
                                    <li class="list-inline-item"><a class="text-xs-center" href="javascript:Didomi.preferences.show()">Politica de cookies</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
                @endguest
            </div>
        </div>
    </div>

    <script>
        if (document.getElementById('menu-toggle')) {
            document.getElementById('menu-toggle').onclick = function () {
                var element = document.getElementById('wrapper');
                element.classList.toggle('toggled');
                var menuIcon = $(this).children('i');
                if (menuIcon.hasClass('ion-android-more-vertical') && !$('wrapper').hasClass('toggle')) {
                    menuIcon.removeClass('ion-android-more-vertical').addClass('ion-android-more-horizontal')
                } else {
                    menuIcon.removeClass('ion-android-more-horizontal').addClass('ion-android-more-vertical')
                }
            }
        }
        window.addEventListener('load',
        function () {

            $('[data-toggle="tooltip"]').tooltip();
            $(".loader").fadeOut();
            $(".page-loader").delay(150).fadeOut("fast");

            //TODO: Hay que adecentar esto

            const url = window.location.hostname
            const partner = url.substring(
                url.indexOf(".") + 1,
                url.lastIndexOf(".")
            );
            const logoRoute = `/img/logos/${partner}.svg`
            const darkLogoRoute = `/img/logos/${partner}_wht.svg`
            const checkLogo = () => {
                
                if( $('body').hasClass('dark')){
                    $('#partnerLogo').attr('src', logoRoute)
                    $('body').removeClass('dark')
                    localStorage.removeItem('theme')
                }else{
                    $('body').addClass('dark')
                    $('#partnerLogo').attr('src', darkLogoRoute)
                    localStorage.setItem('theme', '{dark:true}')
                }
            }

            if(!localStorage.getItem('theme')){
                $('body').removeClass('dark');
                $('#partnerLogo').attr('src', logoRoute)
                $('#themeSelector').prop('checked', false)
            }else{
                $('body').addClass('dark')
                $('#themeSelector').prop('checked', true)
                $('#partnerLogo').attr('src', darkLogoRoute)
            }

            $('#themeSelector').change(function(e){
                checkLogo()
            })
        })
    </script>
    @yield('scripts')

</body>

</html>