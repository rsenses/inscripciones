Estimad@ {{ $checkout->user->full_name }}

Ya estás registrad@ en la {{ $checkout->campaign->name
}}. A continuación detallamos el resumen de la compra:

# Producto
@foreach ($checkout->products->groupBy('id') as $product)
{{ $product->count() }}x {{ $product[0]->name }} {{ $product[0]->mode }}
@endforeach

Si no has completado tu compra, recuerda que puedes hacerlo en cualquier momento desde el siguiente enlace:
{{ route('checkouts', ['checkout' => $checkout, 't' => $checkout->token]) }}

Atentamente,

Correo Farmacéutico

Más información: jornadacf@unidadeditorial.es