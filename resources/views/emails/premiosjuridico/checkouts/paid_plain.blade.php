Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida a la {{ $checkout->campaign->name }}.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Atentamente,
Expansión

Más información: premiosjuridico@expansion.com