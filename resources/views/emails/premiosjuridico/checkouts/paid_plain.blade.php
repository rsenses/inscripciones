Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->campaign->name }}.

Aquí tiene @if($checkout->quantity > 1)sus entradas @else su entrada @endif:
{{ route('tickets.show.checkout', ['checkout' => $checkout, 'token' => $checkout->token]) }}

A través del siguiente enlace podrá acceder a toda la información relativa al evento:
https://premios.juridico.com

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Atentamente,
Expansión

Más información: premios.juridico@unidadeditorial.es