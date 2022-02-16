<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Entrada {{ $registration->product->name }}</title>
    <meta name="description" content="Descripción del encuentro para el que es la entrada">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if($domain === 'telva')
    <style>
        :root {
            /* --primary: #D70065; */
            --primary: #000;
        }
    </style>
    @else
    <style>
        :root {
            --primary: #386AB0;
        }
    </style>
    @endif
    <link rel="stylesheet" href="/css/ticket.css">
</head>

<body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    @if($registration->product->mode === 'presencial')
    <div class="cardWrap">
        <div class="card cardLeft">
            <h1>{{ $registration->product->name }}</h1>
            {{-- <div class="title">
                <h1 style="color: #525252; width:100%; border-bottom: 2px solid black; padding-bottom: .5em; margin-bottom: 1em;">Sesion general</h1>
            </div> --}}
            <div class="name">
                <h2>{{ $registration->user->full_name }}</h2>
                <span>Nombre</span>
            </div>
            <div class="place">
                <h2>{{ $registration->product->place }}</h2>
                <span>Lugar</span>
            </div>
            <div class="time">
                <h2>{{ $registration->product->start_date->formatLocalized("%d %B") }}</h2>
                <span>Día</span>
            </div>
            <div class="time">
                <h2>{{ $registration->product->start_date->format("H:i") }}h</h2>
                <span>Hora</span>
            </div>

        </div>
        <div class="card cardRight">
            <div class="qr-container">
                {{ SimpleSoftwareIO\QrCode\Facades\QrCode::color(...$brand['color'])->format('svg')->generate($registration->unique_id) }}
                <p>{{ $registration->unique_id }}</p>
            </div>
        </div>

    </div>
    @else
    <p>Tu inscripción es online, para poder verlo, entra en el siguiente enlace y accede mediante tu email y contraseña:<br><a href="{{ $registration->campaign->url }}">{{ $registration->campaign->url }}</a></p>
    @endif
    <div class="clearfix"></div>
    <ul class="no-print">
        <li>
            <a href="{{ route('calendar.show', ['product' => $registration->product]) }}"><svg style="height:auto;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg></a>
        </li>
    </ul>
</body>

</html>