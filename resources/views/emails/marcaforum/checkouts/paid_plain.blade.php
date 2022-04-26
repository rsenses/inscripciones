Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->campaign->name }}.

@if(empty($checkout->mode()['online']))
Aquí tienes sus entradas:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}
@elseif(empty($checkout->mode()['presencial']))
Podrá acceder al streaming mediante su email y contraseña.
@else
Aquí tienes sus entradas:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}

Podrá acceder al streaming mediante su email y contraseña.
@endif

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://foro.expansion.com

• Lugar de celebración.
• Programa y ponentes.
• Actualizaciones de última hora.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Atentamente,
MARCA

Más información: eventos@marca.com