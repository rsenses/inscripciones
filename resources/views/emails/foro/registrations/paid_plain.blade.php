Estimad@ {{ $registration->user->full_name }}

Le damos la bienvenida al {{ $registration->product->name }}.

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://foro.expansion.com

• Cómo llegar.
• Programa y ponentes.
• Listado de asistentes.
• Zona de preguntas en directo.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $registration->product]) }}

Esperamos que disfrute del evento,
Expansión

Más información: foro.expansion@unidadeditorial.es