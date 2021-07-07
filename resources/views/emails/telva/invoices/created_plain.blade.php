Estimad@ {{ $invoice->checkout->user->full_name }}

Adjunto enviamos el duplicado de tu factura de inscripción al {{ $invoice->checkout->product->name }}.

https://eventosue.com/invoices/{{ $invoice->number }}.pdf

@if($invoice->checkout->status != 'paid')
Rogamos hagas efectivo el pago de la factura a la mayor brevedad posible dentro de las próximas 48 horas.
@endif

Atentamente,

Telva

Más información: inscripciones.telva@unidadeditorial.es
