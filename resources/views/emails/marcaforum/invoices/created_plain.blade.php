Estimad@ {{ $invoice->checkout->user->full_name }}

Adjunto enviamos el duplicado de su factura de inscripción al {{ $invoice->checkout->campaign->name }}.

https://invoice.eventosue.com/{{ $invoice->number }}.pdf

@if($invoice->checkout->status != 'paid')
Rogamos haga efectivo el pago de la factura a treinta días fecha factura y cómo mínimo 24 horas antes del comienzo del evento.
@endif

Atentamente,

Marca

Más información: eventos@marca.com