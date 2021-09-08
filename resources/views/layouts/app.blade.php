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
        <script src="https://tags.tiqcdn.com/utag/unidadeditorial/telva/prod/utag.sync.js"></script>
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            :root {
                --primary: #1c776b;
            }
        </style>
    @endif
</head>
<body class="{{ $domain }}">
    @if($domain === 'telva')
        <script language="JavaScript" type="text/javascript" >
        var ueDataLayer = ueDataLayer || {};
        ueDataLayer.be_page_url= document.location.href.split("?")[0];
        ueDataLayer.be_page_url_qs= document.location.href;
        ueDataLayer.be_page_article_title= document.title;
        ueDataLayer.be_page_section= document.location.pathname == "/" ? "home" : document.location.pathname.split("/")[1];
        ueDataLayer.be_page_subsection1= typeof document.location.pathname.split("/")[2] == "undefined" ? "" : document.location.pathname.split("/")[2];
        ueDataLayer.be_page_subsection2= typeof document.location.pathname.split("/")[3] == "undefined" ? "" : document.location.pathname.split("/")[3];
        ueDataLayer.be_page_subsection3= typeof document.location.pathname.split("/")[4] == "undefined" ? "" : document.location.pathname.split("/")[4];
        ueDataLayer.be_page_subsection4= typeof document.location.pathname.split("/")[5] == "undefined" ? "" : document.location.pathname.split("/")[5];
        ueDataLayer.be_page_subsection5= typeof document.location.pathname.split("/")[6] == "undefined" ? "" : document.location.pathname.split("/")[6];
        ueDataLayer.be_page_subsection6= typeof document.location.pathname.split("/")[7] == "undefined" ? "" : document.location.pathname.split("/")[7];
        ueDataLayer.be_page_domain="telva.com";
        ueDataLayer.be_page_subdomain= "energiayfelicidad";
        ueDataLayer.be_page_hierarchy= ueDataLayer.be_page_domain + "|" + ueDataLayer.be_page_subdomain + "|" + ueDataLayer.be_page_section + "|" + ueDataLayer.be_page_subsection1 + "|" + ueDataLayer.be_page_subsection2 + "|" + ueDataLayer.be_page_subsection3 + "|" + ueDataLayer.be_page_subsection4 + "|" + ueDataLayer.be_page_subsection5 + "|" + ueDataLayer.be_page_subsection6;
        ueDataLayer.be_text_seoTags="tag1|tag2|tag3";
        ueDataLayer.be_page_site_version="";
        ueDataLayer.be_page_cms_template="otros - i congreso telva energia y felicidad";
        ueDataLayer.be_page_content_type="otros";
        ueDataLayer.be_navigation_type="origen"
        ueDataLayer.be_content_premium_detail="abierto";
        ueDataLayer.be_content_premium="0";
        ueDataLayer.be_content_signwall_detail="abierto";
        ueDataLayer.be_content_signwall="0";
        </script>
        <script type="text/javascript">
          (function(a,b,c,d){
          a='https://tags.tiqcdn.com/utag/unidadeditorial/telva/prod/utag.js';
          b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
          a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
          })();
         </script>
    @endif
    <div id="app">
        <div class="d-flex" id="wrapper">
            @auth
                <!-- Sidebar -->
                <div class="bg-dark border-right" id="sidebar-wrapper">
                    <div class="sidebar-heading">
                        {{ config('app.name', 'Laravel') }}
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('dashboard') }}"
                            class="list-group-item list-group-item-action bg-light"><i class="ion ion-speedometer"
                                aria-hidden="true"></i>&emsp;Dashboard</a>
                        <a href="{{ route('products.index') }}"
                            class="list-group-item list-group-item-action bg-light"><i class="ion ion-briefcase"
                                aria-hidden="true"></i>&emsp;Productos</a>
                        @if(Auth::user()->role === 'superadmin')
                            <a href="{{ route('registrations.index') }}" class="list-group-item list-group-item-action bg-light"><i class="ion ion-pricetags" aria-hidden="true"></i>&emsp;Inscripciones</a>
                            <a href="{{ route('users.index', ['role' => 'customer']) }}" class="list-group-item list-group-item-action bg-light"><i class="ion ion-person-stalker" aria-hidden="true"></i>&emsp;Usuarios</a>
                            <a href="{{ route('partners.index') }}" class="list-group-item list-group-item-action bg-light"><i class="ion ion-filing" aria-hidden="true"></i>&emsp;Cabeceras</a>
                        @endif
                        <a href="{{ route('invoices.index') }}"
                            class="list-group-item list-group-item-action bg-light"><i class="ion ion-cash"
                                aria-hidden="true"></i>&emsp;Financiero</a>
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
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @auth
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}"
                                                method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
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
                                    &copy;{{ date('Y') }} Unidad Editorial Información Económica S.L.
                                </div>
                                <div class="col-12 col-md-6">
                                    <ul class="list-inline text-center text-sm-right">
                                        @if(isset($checkout))
                                            <li class="list-inline-item"><a class="text-xs-center" target="_blank" href="{{ route('terminos-y-condiciones') }}?c={{ $checkout->id }}">Términos y condiciones</a></li>
                                        @endif
                                        <li class="list-inline-item"><a class="text-xs-center" href="http://cookies.unidadeditorial.es" target="_blank">Política de cookies</a></li>
                                     </ul>
                                </div>
                            </div>
                        </div>
                    </footer>
                @endguest
            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/policy_v3_utf8.js"></script>
    <script type="text/javascript" src="https://sdk.privacy-center.org/loader.js" data-key="03f1af55-a479-4c1f-891a-7481345171ce" id="spcloader" async></script>
    <script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/gdpr_dfp.js"></script>
    <script>
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
        @if($domain === 'telva')
            document.getElementById('submit').onclick = function (e) {
                console.log('onclick');
                envioSC("telva energiayfelicidad | pagar con tarjeta" );
            }
        @endif
        window.onload =
            function () {
                $('[data-toggle="tooltip"]').tooltip();
            }

    </script>
    @yield('scripts')
</body>

</html>
