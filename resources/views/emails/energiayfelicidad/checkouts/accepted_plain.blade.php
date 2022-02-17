Estimad@ {{ $checkout->user->full_name }}

Solicitud completada correctamente. A continuación detallamos el resumen de la compra:

# Producto
@foreach ($checkout->products->groupBy('id') as $product)
{{ $product->count() }}x {{ $product[0]->name }} {{ $product[0]->mode }}
@endforeach

Para proceder al pago y confirmar tu asistencia completa tu inscripción en el siguiente enlace:
{{ route('checkouts', ['checkout' => $checkout, 't' => $checkout->token]) }}

Atentamente,

Telva

Más información: inscripciones.telva@unidadeditorial.es