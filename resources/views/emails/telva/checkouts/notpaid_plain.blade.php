Estimad@ {{ $checkout->user->full_name }}

Has seleccionado transferencia bancaria como método de pago. Para reservar tu plaza debe realizar una transferencia con los siguientes datos:

Importe: {{ $checkout->amount }}€
Titular de la cuenta: U.E.INFOR. ECONÓM. S.L.U
Concepto de transferencia: Asistencia {{ $checkout->product->mode === 'online' ? 'Online' : 'Presencial' }} {{ $checkout->user->full_name }} {{ $checkout->id }}
Nombre del Banco: Bankinter
Cuenta 42 0128 6035 77 0100000587
******
IBAN: ES 42 0128 6035 77 0100000587
BIC: SWIFT BKBKESMMXXX

Atentamente,

Telva

Más información: inscripciones.telva@unidadeditorial.es
