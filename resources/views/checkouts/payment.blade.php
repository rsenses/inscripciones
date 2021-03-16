@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <h2>{{ $checkout->product->name }}</h2>
                <div class="card bg-light">
                <img class="card-img-top" src="{{ asset('storage/' . $checkout->product->image) }}" alt="{{ $checkout->product->name }}">
                  <div class="card-body">
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

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="text-center">
                        <strong>CON TARJETA DE DÉBITO/CRÉDITO</strong>
                        </p>
                        <p><img src="{{asset('img/tarjetas.png')}}" class="img-fluid"></p>
                    </div>
                    <div class="card-footer">
                        {!! $form !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="text-center"><strong>CON TRANSFERENCIA desde tu banco:</strong></p>
                        <p>
                        <strong>Beneficiario</strong>: Unidad Editorial Formación S.L.<br>
                        <strong>Cuenta destino</strong>: BBVA - IBAN: ES74 0182 3999 3802 0151 9985 SWIFT: BBVAESMMXXX<br>
                        <strong class="text-danger">Imprescindible</strong>: <strong>Indicar</strong> en el concepto el número de la factura proforma y antes del inicio <strong>enviar justificante de pago</strong> a <a href="mailto:informacion@escuelaunidadeditorial.es?subject=Justificante de pago {{ $checkout->proforma }}" class="btn-link">informacion@escuelaunidadeditorial.es</a>.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('tpv.success', ['checkout' => $checkout, 'method' => 'transfer']) }}" class="btn btn-success btn-block btn-lg"> Pagar por transferencia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
