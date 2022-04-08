Estimad@ {{ $checkout->user->full_name }}

Su reserva ha sido confirmada
Para proceder al pago, haga click en el siguiente enlace:

{{ Config::get('app.url') }}checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Expansión

Más información: premiosjuridico@expansion.com