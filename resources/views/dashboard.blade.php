@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card bg-white mb-5">
        <div class="card-body">
            <h4 class="card-title">Campañas activas</h4>
            <div class="table-responsive">
                <x-campaigns :campaigns="$campaigns" />
            </div>
        </div>
    </div>

    <div class="card bg-white mb-5">
        <div class="card-body">
            <h4 class="card-title">Productos activos</h4>
            <div class="table-responsive">
                <x-products.table :products="$products" />
            </div>
        </div>
    </div>

    <div class="card bg-white mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title">Últimas compras</h3>
                </div>
            </div>
            <x-invoices.table :invoices="$invoices" :toggle="true" />
        </div>
    </div>
</div>
@endsection