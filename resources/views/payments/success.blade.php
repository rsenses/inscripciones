@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <h2>{{ $checkout->product->name }}</h2>
                <div class="table">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Asistente</strong></td>
                                <td>{{ $checkout->user->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Precio</strong></td>
                                <td>{{ $checkout->amount }}€</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success">
                    Compra realizada correctamente.<br>
                    En unos instantes recibirá un email con los detalles de la misma.<br>
                </div>
                @if($checkout->method === 'transfer')
                    <p>Estos son los datos necesarios para realizar la transferencia.</p>
                    <p>
                        <strong>Beneficiario</strong>: Unidad Editorial Formación S.L.<br>
                        <strong>Cuenta destino</strong>: BBVA - IBAN: ES74 0182 3999 3802 0151 9985 SWIFT: BBVAESMMXXX<br>
                        <strong class="text-danger">Imprescindible</strong>: <strong>Indicar</strong> en el concepto el número de la factura proforma y antes del inicio <strong>enviar justificante de pago</strong> a <a href="mailto:foro.expansion@unidadeditorial.es?subject=Justificante de pago {{ $checkout->proforma }}" class="btn-link">foro.expansion@unidadeditorial.es</a>.
                    </p>
                @endif
                <p class="text-center">
                    <a href="{{ $checkout->product->url }}" class="btn btn-info">Volver a la web de "{{ $checkout->product->name }}"</a>
                </p>
            </div>
        </div>
    </div>
@endsection