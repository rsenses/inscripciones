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
        
        @if(!$discount)
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="card bg-light">
                        <div class="card-body">
                            <form method="POST" action="{{ route('deals.store', ['checkout_id' => $checkout->id]) }}" id="discount-data">
                                @csrf
                                <p>Si usted es suscriptor, escriba aquí el código que le han facilitado.</p>
                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                                    <div class="col-md-8">
                                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="code" autofocus>
                                        @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Guardar código</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($message))
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

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
            @if($checkout->amount > 100)
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
            @endif
        </div>
    </div>
@endsection
