Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->product->name }}.

Su inscripción {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} ha sido confirmada.

@if($checkout->product->mode === 'presencial')
Su código de acceso es: $registration->unique_id
@endif

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://energiayfelicidad.telva.com/

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->product]) }}

Esperamos que disfrute del evento,
Telva

Más información: inscripciones.telva@unidadeditorial.es
