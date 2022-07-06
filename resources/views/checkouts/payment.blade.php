@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2>Compra número: {{ $checkout->id }}<br>
                Importe {{ $checkout->amount }}€
            </h2>
            <div class="card bg-white">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Evento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkout->products->groupBy('id') as $product)
                                <tr>
                                    <td>{{ $product->count() }}</td>
                                    <td>{{ $product[0]->name }} <span class="text-uppercase">{{ $product[0]->mode }}</span></td>
                                </tr>
                                @endforeach
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
            <div class="card bg-white">
                <div class="card-body">
                    <form method="POST" action="{{ route('deals.store', ['checkout_id' => $checkout->id]) }}" id="discount_data">
                        @csrf
                        <p>¿Tienes un código de descuento?</p>
                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                            <div class="col-md-8">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Usar código</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($message = Session::get('message'))
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
            <div class="card bg-white">
                <div class="card-body">
                    <p class="text-center">
                        <strong>MEDIANTE TARJETA DE DÉBITO/CRÉDITO</strong>
                    </p>
                    <p><img src="{{asset('img/tarjetas.png')}}" class="img-fluid"></p>
                </div>
                <div class="card-footer">
                    {!! $form !!}
                </div>
            </div>
        </div>
        @if($checkout->campaign->partner->slug !== 'marca' && $checkout->campaign->partner->slug !== 'grupogmp')
        @if(($checkout->amount > 99 && $checkout->campaign->partner->slug !== 'telva') || $checkout->amount > 999)
        <div class="col-lg-6">
            <div class="card bg-white">
                <div class="card-body">
                    <p class="text-center"><strong>MEDIANTE TRANSFERENCIA:</strong></p>
                    <p>
                        <strong>Beneficiario</strong>: {{ $checkout->campaign->partner->legal_name }}<br>
                        <strong>Nombre del Banco</strong>: {{ $checkout->campaign->partner->bank_name }}<br>
                        <strong>Cuenta</strong>: {{ $checkout->campaign->partner->bank_account }}<br>
                        <strong>IBAN</strong>: {{ $checkout->campaign->partner->iban }}<br>
                        <strong>BIC</strong>: {{ $checkout->campaign->partner->bic }}<br>
                        <strong>Concepto de transferencia</strong>: Asistencia {{ $checkout->campaign->from_name }} {{ $checkout->id }}<br>
                    </p>
                </div>
                <div class="card-footer">
                    <a id="transfer_payment" href="{{ route('tpv.success', ['checkout' => $checkout, 'method' => 'transfer']) }}" class="btn btn-success btn-block btn-lg">Pagar por transferencia</a>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection

@if(isset($checkout))
@include('partials.' . $checkout->campaign->partner->client->slug . '.payment')
@endif