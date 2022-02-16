Estimad@ {{ $checkout->user->full_name }}

Solicitud completada correctamente. A continuación detallamos el resumen de la compra:

# Producto
@foreach ($checkout->products->groupBy('id') as $product)
{{ $product->count() }}x {{ $product[0]->name }} {{ $product[0]->mode }}
@endforeach

Para proceder al pago y confirmar tu asistencia regístrate en el siguiente enlace y completa la inscripción:

https://inscripciones.telva.com/checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Telva

Más información: inscripciones.telva@unidadeditorial.es