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
    @else
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #386AB0;
        }
    </style>
    @endif
    <script src="https://tags.tiqcdn.com/utag/unidadeditorial/{{ $domain }}/prod/utag.sync.js"></script>
    <script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/policy_v4.js"></script>
    <script type="text/javascript">
        window.gdprAppliesGlobally = true; (function () {
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
            })("178119d0-5586-4a4c-953e-04aaf9ac0994", "{{ $domain === 'expansion' ? 'JZLiMbKx' : 'DC8decYU' ")
        })();
    </script>
</head>

<body class="{{ $domain }}">
    @yield('scripts_before')

    <div id="app">
        <div class="d-flex" id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper">
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

    @yield('scripts')
</body>

</html>