Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->product->name }}.

Tu inscripción {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} ha sido confirmada.

@if($checkout->product->mode === 'presencial')
Tu código de acceso es: $registration->unique_id
@endif

Unos días antes del evento, te enviaremos un email con toda la información necesaria para acceder al evento.

A través del siguiente enlace podrás acceder a toda la información relativa al evento:
https://energiayfelicidad.telva.com/

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->product]) }}

Esperamos que disfrutes del evento,
Telva

Más información: inscripciones.telva@unidadeditorial.es
