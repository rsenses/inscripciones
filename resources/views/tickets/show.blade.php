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

    <div class="cardWrap {{ $registration->product->mode === 'online' ? 'no-print' : '' }}">
        <div class="card cardLeft">
            <div class="title">
                <h1>{{ $registration->product->name }}</h1>
            </div>
            <div class="name">
                <h2>{{ $registration->user->full_name }}</h2>
                <span>Nombre</span>
            </div>
            <div class="place" style="float: none">
                @if($registration->product->mode === 'presencial')
                <h2>{{ $registration->product->place }}</h2>
                <span>Lugar</span>
                @else
                <h2> <a href="{{ $registration->checkout->campaign->url }}" target="_blank">{{ $registration->checkout->campaign->url }}</a></h2>
                <span>URL</span>
                @endif
            </div>
            <div class="time">
                <h2>{{ $registration->product->start_date->formatLocalized("%d %B") }}</h2>
                <span>Día</span>
            </div>
            <div class="time">
                <h2>{{ $registration->product->start_date->format("H:i") }}h</h2>
                <span>Hora</span>
            </div>
            @if($registration->product->mode === 'online')
            <div class="online-tag">
                <h3>Edición Online<h3>
            </div>
            @endif
        </div>
        <div class="card cardRight">
            <div class="qr-container">
                @if($registration->product->mode === 'online')
                <a href="{{ $registration->checkout->campaign->url }}" target="_blank" style="text-decoration: none">
                    <svg version="1.1" id="text-OL" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 125 125" style="enable-background:new 0 0 125 125;" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                opacity: 0;
                            }

                            .st1 {
                                fill: #FAFAFA;
                            }

                            .st2 {
                                clip-path: url(#SVGID_2_);
                            }

                            .st3 {
                                clip-path: url(#SVGID_4_);
                            }
                        </style>
                        <title>AirPlay_Video_Black</title>
                        <g class="st0">
                            <rect class="st1" width="125" height="125" />
                        </g>
                        <g>
                            <defs>
                                <path id="SVGID_1_" d="M81,88.8c0.4,0.5,0.4,1.3-0.1,1.7c-0.2,0.2-0.5,0.3-0.8,0.3H44.9c-0.7,0-1.2-0.5-1.2-1.2
			c0-0.3,0.1-0.6,0.3-0.8l17.5-20.1c0.5-0.6,1.3-0.6,1.9-0.1c0,0,0.1,0.1,0.1,0.1L81,88.8z M76.9,77.7l-2.8-3.3h10.5
			c0.9,0.1,1.7-0.1,2.5-0.4c0.5-0.3,1-0.7,1.2-1.2c0.4-0.8,0.5-1.7,0.4-2.5V45.8c0.1-0.9-0.1-1.7-0.4-2.5c-0.3-0.5-0.7-1-1.2-1.2
			c-0.8-0.4-1.7-0.5-2.5-0.4h-44c-0.9-0.1-1.7,0.1-2.5,0.4c-0.5,0.3-1,0.7-1.2,1.2c-0.4,0.8-0.5,1.7-0.4,2.5v24.4
			c-0.1,0.9,0.1,1.7,0.4,2.5c0.3,0.5,0.7,1,1.2,1.2c0.8,0.4,1.7,0.5,2.5,0.4h10.5l-2.8,3.3h-6.7c-3,0-4-0.3-5-0.9
			c-1.1-0.6-1.9-1.4-2.5-2.5c-0.6-1.1-0.9-2.1-0.9-5V46.7c0-3,0.3-4,0.9-5.1c0.6-1.1,1.4-1.9,2.5-2.5c1.1-0.6,2.1-0.9,5-0.9h42.2
			c3,0,4,0.3,5.1,0.9c1.1,0.6,1.9,1.4,2.5,2.5c0.6,1.1,0.9,2.1,0.9,5.1v22.5c0,3-0.3,4-0.9,5c-0.6,1.1-1.4,1.9-2.5,2.5
			c-1.1,0.6-2.1,0.9-5.1,0.9L76.9,77.7z" />
                            </defs>
                            <clipPath id="SVGID_2_">
                                <use xlink:href="#SVGID_1_" style="overflow:visible;" />
                            </clipPath>
                            <g class="st2">
                                <g>
                                    <defs>
                                        <rect id="SVGID_3_" x="10.1" y="10.5" width="104.9" height="104.9" />
                                    </defs>
                                    <clipPath id="SVGID_4_">
                                        <use xlink:href="#SVGID_3_" style="overflow:visible;" />
                                    </clipPath>
                                    <g class="st3">
                                        <rect x="24.8" y="30.1" width="75.4" height="68.8" />
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                    {{ $registration->unique_id }}</a>
                @else
                {{ SimpleSoftwareIO\QrCode\Facades\QrCode::color(...$brand['color'])->format('svg')->generate($registration->unique_id) }}
                <p>{{ $registration->unique_id }}</p>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <ul class="no-print">
        <li>
            <a href="{{ route('calendar.show', ['product' => $registration->product]) }}"><svg style="height:30px;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg></a>
        </li>
    </ul>
    <p style="text-align:center"><small>Más información: <a href="mailto:{{ $registration->campaign->from_address }}">{{ $registration->campaign->from_address }}</a></small></p>
</body>

</html>