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
                --primary: #386AB0;
            }
        </style>
    @endif
    <script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/policy_v4.js"></script>
    <script type="text/javascript">window.gdprAppliesGlobally = true; (function () {
            function a(e) {
                if (!window.frames[e]) {
                    if (document.body && document.body.firstChild) { var t = document.body; var n = document.createElement("iframe"); n.style.display = "none"; n.name = e; n.title = e; t.insertBefore(n, t.firstChild) }
                    else { setTimeout(function () { a(e) }, 5) }
                }
            } function e(n, r, o, c, s) {
                function e(e, t, n, a) { if (typeof n !== "function") { return } if (!window[r]) { window[r] = [] } var i = false; if (s) { i = s(e, t, n) } if (!i) { window[r].push({ command: e, parameter: t, callback: n, version: a }) } } e.stub = true; function t(a) {
                    if (!window[n] || window[n].stub !== true) { return } if (!a.data) { return }
                    var i = typeof a.data === "string"; var e; try { e = i ? JSON.parse(a.data) : a.data } catch (t) { return } if (e[o]) { var r = e[o]; window[n](r.command, r.parameter, function (e, t) { var n = {}; n[c] = { returnValue: e, success: t, callId: r.callId }; a.source.postMessage(i ? JSON.stringify(n) : n, "*") }, r.version) }
                }
                if (typeof window[n] !== "function") { window[n] = e; if (window.addEventListener) { window.addEventListener("message", t, false) } else { window.attachEvent("onmessage", t) } }
            } e("__tcfapi", "__tcfapiBuffer", "__tcfapiCall", "__tcfapiReturn"); a("__tcfapiLocator"); (function (e, tgt) {
                var t = document.createElement("script"); t.id = "spcloader"; t.type = "text/javascript"; t.async = true; t.src = "https://sdk.privacy-center.org/" + e + "/loader.js?target_type=notice&target=" + tgt; t.charset = "utf-8"; var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(t, n)
            })("178119d0-5586-4a4c-953e-04aaf9ac0994", "DC8decYU")
        })();</script>
</head>
<body  class="{{ $domain }}">
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
                        <a href="{{ route('dashboard') }}"
                            class="list-group-item list-group-item-action bg-white"><i
                               class="lni lni-dashboard"></i>&emsp;Dashboard</a>
                        <a href="{{ route('products.index') }}"
                            class="list-group-item list-group-item-action bg-white"><i
                               class="lni lni-briefcase"></i>&emsp;Productos</a>
                        @if(Auth::user()->role === 'superadmin')
                            <a href="{{ route('campaigns.index') }}" class="list-group-item list-group-item-action bg-white"><i class="ion ion-ios-analytics" aria-hidden="true"></i>&emsp;Campañas</a>
                            <a href="{{ route('registrations.index') }}"
                               class="list-group-item list-group-item-action bg-white"><i
                                   class="lni lni-pencil-alt"></i>&emsp;Inscripciones</a>
                            <a href="{{ route('users.index', ['role' => 'customer']) }}"
                               class="list-group-item list-group-item-action bg-white"><i
                                   class="lni lni-users"></i>&emsp;Usuarios</a>
                            <a href="{{ route('partners.index') }}"
                               class="list-group-item list-group-item-action bg-white"><i
                                  class="lni lni-bookmark-alt"></i>&emsp;Cabeceras</a>
                        @endif
                        <a href="{{ route('invoices.index') }}"
                            class="list-group-item list-group-item-action bg-white"><i
                               class="lni lni-revenue"></i>&emsp;Financiero</a>
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
                                     <a class="nav-link"
                                        href="#"
                                        role="button"
                                        v-pre>
                                         {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                                     </a>
                                 </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" 
                                         data-toggle="tooltip"
                                        data-placement="bottom"
                                        title=" {{ __('Logout') }}">
                                            <i class="lni lni-exit"></i>
                                        </a>
                                        <form id="logout-form"
                                            action="{{ route('logout') }}"
                                            method="POST"
                                            class="d-none">
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
                                    &copy;{{ date('Y') }} Unidad Editorial Información Económica S.L.
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
            if (document.getElementById('redsys_form')) {
                document.getElementById('redsys_form').onsubmit = function (e) {
                    envioSC("telva energiayfelicidad | pagar con tarjeta");
                }
            }
            if (document.getElementById('invoice-data')) {
                document.getElementById('invoice-data').onsubmit = function (e) {
                    envioSC("telva energiayfelicidad | proceder al pago");
                }
            }
        @endif
        window.onload =
        function () {
            $('[data-toggle="tooltip"]').tooltip();
            $(".loader").fadeOut();
            $(".page-loader").delay(150).fadeOut("fast");
            if(!localStorage.getItem('theme')){
                $('body').removeClass('dark');
                $('#themeSelector').prop('checked', false)
            }else{
                $('body').addClass('dark')
                $('#themeSelector').prop('checked', true)
            }

            $('#themeSelector').change(function(e){
                if( $('body').hasClass('dark')){
                    $('body').removeClass('dark')
                    localStorage.removeItem('theme')
                 }else{
                     $('body').addClass('dark')
                     localStorage.setItem('theme', '{dark:true}')
                 }
            })
        }

            

    </script>
    @yield('scripts')
</body>

</html>
