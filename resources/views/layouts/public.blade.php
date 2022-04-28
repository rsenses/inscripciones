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

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if(isset($checkout))
    @include('partials.' . $checkout->campaign->partner->client->slug . '.head')
    @endif
</head>

<body class="{{ $domain }}">
    @if(isset($checkout))
    @include('partials.' . $checkout->campaign->partner->client->slug . '.body')
    @endif

    <div id="app">
        <div class="d-flex" id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @if(isset($checkout))
    @include('partials.' . $checkout->campaign->partner->client->slug . '.footer')
    @endif
</body>

</html>