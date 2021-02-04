@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Productos <small><a href="{{ route('products.create') }}">Nuevo producto</a></small></h2>
        <x-products.table :products="$products"/>
    </div>
@endsection
