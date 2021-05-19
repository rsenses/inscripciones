Estimad@ {{ $checkout->user->full_name }}

Su solicitud para asistir al {{ $checkout->product->name }} ha sido aceptada.

@if($promo === 'SUSCRIPTOR' || $promo === 'PREMIUM')
Para beneficiarse por ser suscriptor, incorpore el siguiente código de descuento durante el proceso de pago: <b>{{ $discount->code }}</b> y se le aplicará un descuento del {{ $discount->quantity }}%.
@endif

Para proceder al pago y confirmar su asistencia {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} regístrese en el siguiente enlace y complete su inscripción:
          
{{ Config::get('app.url') }}checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Relaciones Institucionales
Expansión

Más información: foro.expansion@unidadeditorial.es