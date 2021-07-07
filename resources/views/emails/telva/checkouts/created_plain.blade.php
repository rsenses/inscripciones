Estimad@ {{ $checkout->user->full_name }}

Tu solicitud para asistir al {{ $checkout->product->name }} ha sido completada correctamente.

Para proceder al pago y confirmar tu asistencia {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} regístrese en el siguiente enlace y complete tu inscripción:
          
https://inscripciones.telva.com/checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Telva

Más información: inscripciones.telva@unidadeditorial.es