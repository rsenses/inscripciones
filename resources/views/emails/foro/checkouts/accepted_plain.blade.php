Estimad@ {{ $checkout->user->full_name }}

Su solicitud ha sido completada correctamente.

Para proceder al pago y confirmar su asistencia haga click en el siguiente enlace:

{{ Config::get('app.url') }}checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Expansión

Más información: foro.expansion@unidadeditorial.es