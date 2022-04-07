Estimad@ {{ $checkout->user->full_name }}

Le damos la bienvenida al {{ $checkout->campaign->name }}.

Incluir en mi calendario: {{ route('calendar.show', ['product' => $checkout->products[0]]) }}

Atentamente,
Expansión

Más información: premios.juridico@unidadeditorial.es