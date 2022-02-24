<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Entradas de {{ $checkout->user->full_name }}</title>
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

    @if($registrations->count())
    <div class="no-print advice-container">
        <p>
            Si es otra persona diferente a ti la que va a asistir, puedes compartir la entrada con ella por whatsapp o email (iconos debajo de la entrada). Tendrá que rellenar sus datos personales para <strong>asignarle la entrada y recibirla por email</strong>.
        </p>
    </div>
    <div class="no-print advice-container advice-container_online">
        @if(!empty($checkout->mode()['online']))
        <p>Para inscripciones online, podrás acceder al streaming mediante tu email y contraseña desde:<br>
            <a href="{{ $checkout->campaign->url }}" target="_blank">{{ $checkout->campaign->url }}</a>
        </p>
        @endif
    </div>
    @endif

    @foreach($registrations as $registration)
    <div class="cardWrap {{ $registration->product->mode === 'online' ? 'no-print' : '' }}">
        <div class="card cardLeft">
            <div class="title">
                <h1>{{ $registration->product->name }}</h1>
            </div>
            {{-- <div class="title">
                <h1 style="color: #525252; width:100%; border-bottom: 2px solid black; padding-bottom: .5em; margin-bottom: 1em;">Sesion general</h1>
            </div> --}}
            <div class="name">
                <h2>{{ $registration->user->full_name }}</h2>
                <span>Nombre</span>
            </div>
            <div class="place" style="float: none">
                @if($registration->product->mode === 'presencial')
                <h2>{{ $registration->product->place }}</h2>
                <span>Lugar</span>
                @else
                <h2> <a href="{{ $checkout->campaign->url }}" target="_blank">{{ $checkout->campaign->url }}</a></h2>
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
                <a href="{{ $checkout->campaign->url }}" target="_blank" style="text-decoration: none">
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
        @if($registration->product->mode === 'presencial' && ($registration->user_id === $checkout->user_id))
        <li><a href="https://wa.me/?text=Entrada para {{ $registration->product->name }} {{ route('tickets.show', [$registration, $registration->unique_id]) }}" onclick="envioEventoRedSocial('mail');" class="mail" target="_blank" title="Compártelo por email" rel="nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" style="height:30px;max-height:30px" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                    <path d="M 12.011719 2 C 6.5057187 2 2.0234844 6.478375 2.0214844 11.984375 C 2.0204844 13.744375 2.4814687 15.462563 3.3554688 16.976562 L 2 22 L 7.2324219 20.763672 C 8.6914219 21.559672 10.333859 21.977516 12.005859 21.978516 L 12.009766 21.978516 C 17.514766 21.978516 21.995047 17.499141 21.998047 11.994141 C 22.000047 9.3251406 20.962172 6.8157344 19.076172 4.9277344 C 17.190172 3.0407344 14.683719 2.001 12.011719 2 z M 12.009766 4 C 14.145766 4.001 16.153109 4.8337969 17.662109 6.3417969 C 19.171109 7.8517969 20.000047 9.8581875 19.998047 11.992188 C 19.996047 16.396187 16.413812 19.978516 12.007812 19.978516 C 10.674812 19.977516 9.3544062 19.642812 8.1914062 19.007812 L 7.5175781 18.640625 L 6.7734375 18.816406 L 4.8046875 19.28125 L 5.2851562 17.496094 L 5.5019531 16.695312 L 5.0878906 15.976562 C 4.3898906 14.768562 4.0204844 13.387375 4.0214844 11.984375 C 4.0234844 7.582375 7.6067656 4 12.009766 4 z M 8.4765625 7.375 C 8.3095625 7.375 8.0395469 7.4375 7.8105469 7.6875 C 7.5815469 7.9365 6.9355469 8.5395781 6.9355469 9.7675781 C 6.9355469 10.995578 7.8300781 12.182609 7.9550781 12.349609 C 8.0790781 12.515609 9.68175 15.115234 12.21875 16.115234 C 14.32675 16.946234 14.754891 16.782234 15.212891 16.740234 C 15.670891 16.699234 16.690438 16.137687 16.898438 15.554688 C 17.106437 14.971687 17.106922 14.470187 17.044922 14.367188 C 16.982922 14.263188 16.816406 14.201172 16.566406 14.076172 C 16.317406 13.951172 15.090328 13.348625 14.861328 13.265625 C 14.632328 13.182625 14.464828 13.140625 14.298828 13.390625 C 14.132828 13.640625 13.655766 14.201187 13.509766 14.367188 C 13.363766 14.534188 13.21875 14.556641 12.96875 14.431641 C 12.71875 14.305641 11.914938 14.041406 10.960938 13.191406 C 10.218937 12.530406 9.7182656 11.714844 9.5722656 11.464844 C 9.4272656 11.215844 9.5585938 11.079078 9.6835938 10.955078 C 9.7955938 10.843078 9.9316406 10.663578 10.056641 10.517578 C 10.180641 10.371578 10.223641 10.267562 10.306641 10.101562 C 10.389641 9.9355625 10.347156 9.7890625 10.285156 9.6640625 C 10.223156 9.5390625 9.737625 8.3065 9.515625 7.8125 C 9.328625 7.3975 9.131125 7.3878594 8.953125 7.3808594 C 8.808125 7.3748594 8.6425625 7.375 8.4765625 7.375 z"></path>
                </svg>
            </a></li>
        <li><a href="mailto:?subject=Entrada para {{ $registration->product->name }}&amp;body={{ route('tickets.show', [$registration, $registration->unique_id]) }}" onclick="envioEventoRedSocial('mail');" class="mail" target="_blank" title="Compártelo por email" rel="nofollow">
                <svg style="height:30px;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a></li>
        @endif
        <li>
            <a href="{{ route('calendar.show', ['product' => $registration->product]) }}"><svg style="height:30px;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg></a>
        </li>
    </ul>
    @endforeach
    <p style="text-align:center"><small>Más información: <a href="mailto:{{ $checkout->campaign->from_address }}">{{ $checkout->campaign->from_address }}</a></small></p>
</body>

</html>