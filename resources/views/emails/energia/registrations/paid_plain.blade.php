Estimad@ {{ $registration->user->full_name }}

Le damos la bienvenida al {{ $registration->product->name }}. Su inscripción ha sido confirmada.

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://foro.expansion.com

• Cómo llegar.
• Programa y ponentes. 
• Listado de asistentes.
• Protocolo Covid.
• Zona de preguntas en directo.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $registration->product]) }}

Esperamos que disfrutes del evento,

Telva

Más información: inscripciones.telva@unidadeditorial.es
