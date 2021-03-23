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
                        <strong>Beneficiario</strong>: U.E.INFOR. ECONÓM. S.L.U<br>
                        <strong>Nombre del Banco</strong>: Bankinter<br>
                        <strong>Cuenta</strong>: 42 0128 6035 77 0100000587<br>
                        <strong>IBAN</strong>: ES 42 0128 6035 77 0100000587<br>
                        <strong>BIC</strong>: SWIFT BKBKESMMXXX<br>
                        <strong>Concepto de transferencia</strong>: Asistencia {{ $checkout->product->mode === 'online' ? 'Online' : 'Presencial' }} {{ $checkout->user->full_name }} {{ $checkout->invoice->number }}<br>
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
