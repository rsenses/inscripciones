Estimad@ {{ $checkout->user->full_name }}

Su solicitud ha sido completada correctamente.

Para proceder al pago y confirmar su asistencia haga click en el siguiente enlace:

{{ route('checkouts', ['checkout' => $checkout, 't' => $checkout->token]) }}

Atentamente,

MARCA

Más información: eventos@marca.com