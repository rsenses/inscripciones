@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $product->name }}
        <a class="pull-right btn btn-info text-light" title="editar"
            href="{{ route('products.edit', ['product' => $product]) }}"
            data-toggle="tooltip" data-placement="bottom">
            <i class="ion ion-edit"></i>
        </a>
    </h2>
    @if($product->description)
        <p>{{ $product->description }}</p>
    @endif
    <div class="row mb-5 align-items-stretch">
        <div class="col col-sm-4">
        <div class="card bg-light h-100">
          <div class="card-body">
          <p><img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://www.fillmurray.com/400/600' }}"
                    alt="El producto no tiene imagen" class="img-fluid"></p>
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
                            <tr>
                                <td>Modalidad</td>
                                <td>{{ $product->mode }}</td>
                            </tr>
                            <tr>
                                <td>Lugar de Celebración</td>
                                <td>{{ $product->place }}</td>
                            </tr>
                            <tr>
                                <td>Fecha de inicio</td>
                                <td>{{ $product->start_date }}</td>
                            </tr>
                            <tr>
                                <td>Fecha de fin</td>
                                <td>{{ $product->end_date }}</td>
                            </tr>
                            <tr>
                                <td>Cabeceras</td>
                                <td>
                                    @foreach($product->partners as $partner)
                                        {{ $partner->name }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

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
