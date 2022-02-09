Estimad@ {{ $checkout->user->full_name }}

Su solicitud ha sido completada correctamente. A continuación le enviamos el resumen de su compra:

Cantidad    Producto
@foreach ($checkout->products->groupBy('id') as $product)
{{ $product->count() }}x {{ $product[0]->name }} {{ $product[0]->mode }}
@endforeach

Para proceder al pago y confirmar su asistencia regístrese en el siguiente enlace y complete su inscripción:
          
{{ Config::get('app.url') }}checkouts/{{ $checkout->id }}?t={{ $checkout->token }}

Atentamente,

Relaciones Institucionales
Expansión

Más información: foro.expansion@unidadeditorial.es