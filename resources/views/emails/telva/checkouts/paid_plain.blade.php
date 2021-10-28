Estimad@ {{ $checkout->user->full_name }}

Ya puedes ver en diferido el {{ $checkout->product->name }}.

Tu inscripción {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} ha sido confirmada.

@if($checkout->product->mode === 'presencial')
Tu código de acceso es: $registration->unique_id
@endif

A través del siguiente enlace podrás acceder a toda la información relativa al evento y a los vídeos:
https://energiayfelicidad.telva.com/

Pincha en el botón "VUELVE A VERLO" del menú principal y accede mediante tu email y la contraseña que has elegido al inscribirte.

Esperamos que disfrutes del evento,
Telva

Más información: inscripciones.telva@unidadeditorial.es
