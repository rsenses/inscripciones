Estimad@ {{ $checkout->user->full_name }}

Has seleccionado transferencia bancaria como método de pago. Para reservar tu plaza debes realizar una transferencia con los siguientes datos:

Importe: {{ $checkout->amount }}€
Titular de la cuenta: {{ $checkout->campaign->partner->legal_name }}
Concepto de transferencia: Asistencia {{ $checkout->user->full_name }} {{ $checkout->id }}
Nombre del Banco: {{ $checkout->campaign->partner->bank_name }}
Cuenta {{ $checkout->campaign->partner->bank_account }}
******
IBAN: {{ $checkout->campaign->partner->iban }}
BIC: {{ $checkout->campaign->partner->bic }}

Por favor, envíanos el justificante de la transferencia respondiendo a este email.

Atentamente,

Correo Farmacéutico

Más información: jornadacf@unidadeditorial.es