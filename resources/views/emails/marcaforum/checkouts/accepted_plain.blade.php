Estimad@ {{ $checkout->user->full_name }}

Su registro ha sido completado correctamente. A continuación detallamos el resumen de la compra:

# Producto
@foreach ($checkout->products->groupBy('id') as $product)
{{ $product->count() }}x {{ $product[0]->name }} {{ $product[0]->mode }}
@endforeach

Si no ha completado el pago, le recordamos que puede hacerlo en cualquier momento desde el siguiente enlace:
{{ route('checkouts', ['checkout' => $checkout, 't' => $checkout->token]) }}

Atentamente,

MARCA

Más información: eventos@marca.com