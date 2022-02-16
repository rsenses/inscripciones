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
    <div class="no-print">
        <p>
            Cada entrada puede ser compartida, la persona que habra el enlace, podrá rellenar sus datos personales y así tener esa entrada asignada y enviada por email.
        </p>
        <p>
            Solo aparecerán las entradas no asignadas. Si has compartida la entrada con alguien y esa persona ha rellenado los datos, no verás aquí esa entrada.
        </p>
        @if(!empty($checkout->mode()['online']))
        <p>Para inscripciones online, podrás acceder al streaming mediante tu usuario y contraseña desde:<br>
            <a href="{{ $checkout->campaign->url }}" target="_blank">{{ $checkout->campaign->url }}</a>
        </p>
        @endif
    </div>
    @endif

    @forelse($registrations as $registration)
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
    <div class="clearfix"></div>
    <ul class="no-print">
        <li><a href="https://wa.me/?text=Entrada para {{ $registration->product->name }} {{ route('tickets.show', [$registration, $registration->unique_id]) }}" onclick="envioEventoRedSocial('mail');" class="mail" target="_blank" title="Compártelo por email" rel="nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" style="height:auto;max-height:30px" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                    <path d="M 12.011719 2 C 6.5057187 2 2.0234844 6.478375 2.0214844 11.984375 C 2.0204844 13.744375 2.4814687 15.462563 3.3554688 16.976562 L 2 22 L 7.2324219 20.763672 C 8.6914219 21.559672 10.333859 21.977516 12.005859 21.978516 L 12.009766 21.978516 C 17.514766 21.978516 21.995047 17.499141 21.998047 11.994141 C 22.000047 9.3251406 20.962172 6.8157344 19.076172 4.9277344 C 17.190172 3.0407344 14.683719 2.001 12.011719 2 z M 12.009766 4 C 14.145766 4.001 16.153109 4.8337969 17.662109 6.3417969 C 19.171109 7.8517969 20.000047 9.8581875 19.998047 11.992188 C 19.996047 16.396187 16.413812 19.978516 12.007812 19.978516 C 10.674812 19.977516 9.3544062 19.642812 8.1914062 19.007812 L 7.5175781 18.640625 L 6.7734375 18.816406 L 4.8046875 19.28125 L 5.2851562 17.496094 L 5.5019531 16.695312 L 5.0878906 15.976562 C 4.3898906 14.768562 4.0204844 13.387375 4.0214844 11.984375 C 4.0234844 7.582375 7.6067656 4 12.009766 4 z M 8.4765625 7.375 C 8.3095625 7.375 8.0395469 7.4375 7.8105469 7.6875 C 7.5815469 7.9365 6.9355469 8.5395781 6.9355469 9.7675781 C 6.9355469 10.995578 7.8300781 12.182609 7.9550781 12.349609 C 8.0790781 12.515609 9.68175 15.115234 12.21875 16.115234 C 14.32675 16.946234 14.754891 16.782234 15.212891 16.740234 C 15.670891 16.699234 16.690438 16.137687 16.898438 15.554688 C 17.106437 14.971687 17.106922 14.470187 17.044922 14.367188 C 16.982922 14.263188 16.816406 14.201172 16.566406 14.076172 C 16.317406 13.951172 15.090328 13.348625 14.861328 13.265625 C 14.632328 13.182625 14.464828 13.140625 14.298828 13.390625 C 14.132828 13.640625 13.655766 14.201187 13.509766 14.367188 C 13.363766 14.534188 13.21875 14.556641 12.96875 14.431641 C 12.71875 14.305641 11.914938 14.041406 10.960938 13.191406 C 10.218937 12.530406 9.7182656 11.714844 9.5722656 11.464844 C 9.4272656 11.215844 9.5585938 11.079078 9.6835938 10.955078 C 9.7955938 10.843078 9.9316406 10.663578 10.056641 10.517578 C 10.180641 10.371578 10.223641 10.267562 10.306641 10.101562 C 10.389641 9.9355625 10.347156 9.7890625 10.285156 9.6640625 C 10.223156 9.5390625 9.737625 8.3065 9.515625 7.8125 C 9.328625 7.3975 9.131125 7.3878594 8.953125 7.3808594 C 8.808125 7.3748594 8.6425625 7.375 8.4765625 7.375 z"></path>
                </svg>
            </a></li>
        <li><a href="mailto:?subject=Entrada para {{ $registration->product->name }}&amp;body={{ route('tickets.show', [$registration, $registration->unique_id]) }}" onclick="envioEventoRedSocial('mail');" class="mail" target="_blank" title="Compártelo por email" rel="nofollow">
                <svg style="height:auto;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a></li>
        <li>
            <a href="{{ route('calendar.show', ['product' => $registration->product]) }}"><svg style="height:auto;max-height:30px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg></a>
        </li>
    </ul>
    @else
    <div class="no-print">
        <p>TODO: Esto es una entrada online</p>
        <p><a href="{{ route('tickets.show', [$registration, $registration->unique_id]) }}">{{ route('tickets.show', [$registration, $registration->unique_id]) }}</a></p>
    </div>
    @endif
    @empty
    <p>Todas las entradas de esta compra han sido asignadas a otros usuarios</p>
    @endforelse
</body>

</html>