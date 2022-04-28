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
                    <p class="card-text">
                    <div class="table-responsive mb-4">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                    <div class="justify-content-center">
                        <div class="col-12">
                            @if($checkout->method != 'card' && $checkout->amount > 0)
                            <div class="alert alert-success">
                                Registro realizado correctamente.<br>
                                En breve le llegará un email con las indicaciones para poder completar el pago mediante transferencia bancaria.
                            </div>
                            @else
                            <div class="alert alert-success">
                                Compra realizada correctamente.<br>
                                En unos instantes recibirá un email con los detalles de la misma.<br>
                            </div>
                            @endif
                            <p class="text-center">
                                <a href="{{ $checkout->campaign->url }}" class="btn btn-info">
                                    <i class="ion ion-arrow-return-left" aria-hidden="true"></i>
                                    Volver a la web del evento</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if(isset($checkout))
@include('partials.' . $checkout->campaign->partner->client->slug . '.success')
@endif