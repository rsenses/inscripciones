Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->product->name }}.

Su inscripción {{ $checkout->product->mode === 'online' ? 'ON LINE' : 'PRESENCIAL' }} ha sido confirmada, a través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://foro.expansion.com

• Cómo llegar.
• Programa y ponentes. 
• Listado de asistentes.
• Protocolo Covid.
• Zona de preguntas en directo.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->product]) }}

Esperamos que disfrute del evento,
Relaciones Institucionales
Expansión

Más información: foro.expansion@unidadeditorial.es
