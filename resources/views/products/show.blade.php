@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $product->name }} <small class="text-xs"><a href="{{ route('products.edit', ['product' => $product]) }}">Editar</a></small></h2>
        @if($product->description)
            <p>{{ $product->description }}</p>
        @endif
        <div class="row">
            <div class="col col-sm-4">
                <p><img src="{{ asset('storage/' . $product->image) }}" alt="El producto no tiene imagen" class="img-fluid"></p>
            </div>
            <div class="col col-sm-8">
                <div class="table">
                    <table class="table table-striped">
                        <tr>
                            <td>Precio</td>
                            <td>{{ $product->price }}</td>
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
        <hr class="my-5">
        <h3>Inscripciones</h3>
        <x-registrations.table :registrations="$registrations" :show-product="false"/>
    </div>
@endsection
