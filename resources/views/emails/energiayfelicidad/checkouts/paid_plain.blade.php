Estimad@ {{ $checkout->user->full_name }}

Te damos la bienvenida al {{ $checkout->campaign->name }}. Su inscripción ha sido confirmada.

@if(empty($checkout->mode()['online']))
Aquí tienes tus entradas:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}
@elseif(empty($checkout->mode()['presencial']))
Podrás acceder al streaming mediante tu email y contraseña.
@else
Aquí tienes tus entradas:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}

Podrás acceder al streaming mediante tu email y contraseña.
@endif

A través del siguiente enlace podrás ver toda la información relativa al evento:
https://energiayfelicidad.telva.com/

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Esperamos que disfrutes del evento,

Telva

Más información: inscripciones.telva@unidadeditorial.es