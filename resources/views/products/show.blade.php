@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>{{ $product->name }} <span class="badge badge-info">{{ $product->mode }}</span>
        @if(Auth::user()->role === 'superadmin')
            <a class="pull-right btn btn-info text-light" title="editar"
                href="{{ route('products.edit', ['product' => $product]) }}"
                data-toggle="tooltip" data-placement="bottom">
                <i class="ion ion-edit"></i>
            </a>
        @endif
    </h2>
    @if($product->description)
        <p>{{ $product->description }}</p>
    @endif
    <div class="row mb-5 align-items-stretch">
        <div class="col col-sm-4">
            <div class="card bg-light h-100">
              <div class="card-body d-flex align-items-center">
              <p><img src="{{ asset('storage/' . $product->campaign->image) }}" alt="El producto no tiene imagen" class="img-fluid"></p>
              </div>
            </div>
        </div>
        <div class="col col-sm-8">
            <div class="card text-white bg-light">
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>Precio</td>
                                <td>{{ $product->price }} €</td>
                            </tr>
                            @if($product->mode === 'presencial')
                                <tr>
                                    <td>Lugar de Celebración</td>
                                    <td>{{ $product->place }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Fecha de inicio</td>
                                <td>{{ $product->start_date->format('d-m-Y / H:i' ) }}</td>
                            </tr>
                            <tr>
                                <td>Fecha de fin</td>
                                <td>{{ $product->end_date->format('d-m-Y / H:i' ) }}</td>
                            </tr>
                            <tr>
                                <td>Campaña</td>
                                <td>{{ $product->campaign->name }}</td>
                            </tr>
                            <tr>
                                <td>Cabecera</td>
                                <td>{{ $product->campaign->partner->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card bg-light mb-5">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Sin valorar</td>
                    <td>{{ $product->new_registrations_count }}</td>
                </tr>
                <tr>
                    <td>Aceptadas</td>
                    <td>
                        {{ $product->registrations_accepted_count }}<br>
                        <small>Pagadas</small>: {{ $product->registrations_paid_count }}<br>
                        <small>Sin pagar</small>: {{ $product->registrations_pending_count }} <small class="text-info">(aceptadas + pendientes de pago)</small>
                    </td>
                </tr>
                <tr>
                    <td>Denegadas</td>
                    <td>{{ $product->registrations_denied_count }}</td>
                </tr>
                <tr>
                    <td>Canceladas</td>
                    <td>{{ $product->registrations_cancelled_count }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body">
            <h2 class="card-title text-primary">Inscripciones</h2>
            <x-registrations.table :registrations="$registrations" :show-product="false" />
        </div>
    </div>


</div>
@endsection
