@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>{{ $product->name }} <span class="badge badge-info">{{ $product->mode }}</span>
        @if(Auth::user()->role === 'superadmin')
        <a class="pull-right btn btn-white text-primary border border-primary" title="editar" href="{{ route('products.edit', ['product' => $product]) }}" data-toggle="tooltip" data-placement="bottom">
            <i class="ion ion-edit"></i>
        </a>
        @endif
    </h2>

    <div class="row mb-5 align-items-stretch">
        <div class="col col-sm-4">
            <div class="card bg-white h-100">
                <div class="card-body d-flex align-items-center">
                    <p><img src="{{ asset('storage/' . $product->campaign->image) }}" alt="El producto no tiene imagen" class="img-fluid"></p>
                </div>
            </div>
        </div>
        <div class="col col-sm-8">
            <div class="card text-white">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
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

    <div class="card bg-white mb-5">
        <div class="card-body">
            <table class="table ">
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
    <div class="card bg-white">
        <div class="card-body">
            <h4 class="card-title">Inscripciones</h4>
            <x-registrations.table :registrations="$registrations" :product="$product" :show-product="false" />
        </div>
    </div>
</div>


</div>
@endsection