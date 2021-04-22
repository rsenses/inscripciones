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
                                @if($checkout->method != 'card')
                                    <div class="alert alert-success">
                                        Inscripción realizada correctamente.<br>
                                        En unos instantes recibirá un email con los detalles de la misma.<br>
                                    </div>
                                    <p>Para reservar su plaza debe realizar una transferencia con los siguientes datos:</mj-text>
                                    <p>Importe: {{ $checkout->amount }}€<br>
                                      Titular de la cuenta: U.E.INFOR. ECONÓM. S.L.U<br>
                                      Concepto de transferencia: Asistencia {{ $checkout->product->mode === 'online' ? 'Online' : 'Presencial' }} {{ $checkout->user->full_name }} {{ $checkout->id }}<br>
                                      Nombre del Banco: Bankinter<br>
                                      Cuenta 42 0128 6035 77 0100000587<br>
                                      ******<br>
                                      IBAN: ES 42 0128 6035 77 0100000587<br>
                                      BIC: SWIFT BKBKESMMXXX</p>
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
