Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->products[0]->name }}.

Su inscripción {{ $checkout->products[0]->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} ha sido confirmada.

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://foro.expansion.com

• Cómo llegar.
• Programa y ponentes. 
• Listado de asistentes.
• Protocolo Covid.
• Zona de preguntas en directo.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Esperamos que disfrutes del evento,
Relaciones Institucionales
Expansión

Más información: foro.expansion@unidadeditorial.es
