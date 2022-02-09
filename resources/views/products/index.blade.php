@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card bg-light">
        <div class="card-body">
            <h4 class="card-title">Productos
                @if(Auth::user()->role === 'superadmin')
                    <a class="btn btn-white rounded-circle text-primary border border-primary pull-right d-block mb-1"
                       data-toggle="tooltip"
                       data-placement="bottom"
                       title="Crear nuevo"
                       href="{{ route('products.create') }}">
                        <i class="ion ion-plus"></i>
                    </a>
                @endif
            </h4>
            <x-products.table :products="$products" />
        </div>
    </div>

</div>
@endsection
