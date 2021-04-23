Estimad@ {{ $invoice->checkout->user->full_name }}

Adjunto enviamos el duplicado de su factura de asistencia al {{ $invoice->checkout->product->name }}.

https://eventosue.com/invoices/{{ $invoice->number }}.pdf

@if($invoice->checkout->status != 'paid')
Rogamos haga efectivo el pago de la factura a treinta días fecha factura y cómo mínimo 24 horas antes del comienzo del evento.
@endif

Atentamente,

Relaciones Institucionales
Expansión

Más información: foro.expansion@unidadeditorial.es