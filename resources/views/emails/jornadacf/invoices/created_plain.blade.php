Estimad@ {{ $invoice->checkout->user->full_name }}

Adjunto enviamos el duplicado de tu factura de inscripción al {{ $invoice->checkout->campaign->name }}.

https://invoice.eventosue.com/{{ $invoice->number }}.pdf

@if($invoice->checkout->status != 'paid')
Rogamos hagas efectivo el pago de la factura a treinta días fecha factura y cómo mínimo 24 horas antes del comienzo del evento.
Por favor, envíenos el justificante de la transferencia a jornadacf@unidadeditorial.es
@endif

Atentamente,

Correo Farmacéutico

Más información: jornadacf@unidadeditorial.es