Estimad@ {{ $registration->user->full_name }}

Le damos la bienvenida al {{ $registration->product->name }}.

Puede descargar su entrada desde el siguiente enlace:
{{ route('tickets.show', [$registration, $registration->unique_id]) }}

Acceda a toda la información relativa al evento en:
https://foro.expansion.com

• Lugar de celebración.
• Programa y ponentes.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $registration->product]) }}

Esperamos que disfrute del evento,
MARCA

Más información: eventos@marca.com