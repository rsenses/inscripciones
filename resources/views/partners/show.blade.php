@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $partner->name }} <small class="text-xs"><a href="{{ route('partners.edit', ['partner' => $partner]) }}">Editar</a></small></h2>
        @if($partner->image)
            <p>
                <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">
            </p>
        @endif
        <hr class="my-5">
        <h3>Productos</h3>
        <x-products.table :products="$products" />
    </div>
@endsection
