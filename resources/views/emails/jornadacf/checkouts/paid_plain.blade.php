Estimad@ {{ $checkout->user->full_name }}

Te damos la bienvenida a la {{ $checkout->campaign->name }}.

@if(empty($checkout->mode()['online']))
Aquí tienes tus entradas:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}

Te esperamos el próximo 13 de junio a las 8.45 en el Salón Círculo Palace del Hotel Westin Palace de Madrid. Entrada por Plaza de Neptuno, 28014 Madrid.
@endif

A través del siguiente enlace podrás ver toda la información relativa al evento:
https://jornadagestioncf.diariomedico.com/

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Esperamos que disfrutes del evento,

Correo Farmacéutico

Más información: jornadacf@unidadeditorial.es