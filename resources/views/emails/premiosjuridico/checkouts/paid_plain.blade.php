Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->campaign->name }}.

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://premios.juridico.com

• Cómo llegar.
• Programa y ponentes.
• Listado de asistentes.
• Zona de preguntas en directo.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Atentamente,
Expansión

Más información: premios.juridico@unidadeditorial.es