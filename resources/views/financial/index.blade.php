@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2>Productos activos</h2>
        <x-products.table :products="$products"/>

        <h2 class="mt-5">Últimas inscripciones</h2>
        <x-registrations.table :registrations="$registrations"/>
    </div>
@endsection
