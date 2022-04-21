Estimad@ {{ $registration->user->full_name }}

Te damos la bienvenida al {{ $registration->product->name }}.

Puedes descargar tu entrada desde el siguiente enlace:
{{ route('tickets.show', [$registration, $registration->unique_id]) }}

A través del siguiente enlace podrás acceder a toda la información relativa al evento:
https://energiayfelicidad.telva.com

Incluir en mi calendario: {{ route('calendar.show', ['product' => $registration->product]) }}

Esperamos que disfrutes del evento,

Telva

Más información: inscripciones.telva@unidadeditorial.es