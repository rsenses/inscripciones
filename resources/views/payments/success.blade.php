@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2>{{ $checkout->product->name }}</h2>

            <div class="card bg-light">
                <div class="card-body">
                <img class="card-img-top" src="{{ asset('storage/' . $checkout->product->image) }}" alt="{{ $checkout->product->name }}">
                    <p class="card-text">
                        <div class="table mb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Asistente</strong></td>
                                        <td>{{ $checkout->user->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Precio</strong></td>
                                        <td class="text-right">{{ $checkout->amount }}€</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="justify-content-center">
                            <div class="col-12">
                                @if($checkout->method != 'card' && $checkout->amount > 0)
                                    <div class="alert alert-success">
                                        Registro realizada correctamente.<br>
                                        En breve le llegará un email con las indicaciones para poder completar el pago mediante transferencia bancaria.
                                    </div>
                                @else
                                    <div class="alert alert-success">
                                        Compra realizada correctamente.<br>
                                        En unos instantes recibirá un email con los detalles de la misma.<br>
                                    </div>
                                @endif
                                <p class="text-center">
                                    <a href="{{ $checkout->product->url }}" class="btn btn-info">
                                    <i class="ion ion-arrow-return-left" aria-hidden="true"></i>
                                    Volver a la web de
                                        "{{ $checkout->product->name }}"</a>
                                </p>
                            </div>
                        </div>
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
