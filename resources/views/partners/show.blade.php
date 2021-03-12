@extends('layouts.app')

@section('content')
<div class="container">
<div>
    
</div>
    <h2>
    
    @if($partner->image)
            <img src="{{ asset('storage/' . $partner->image) }}"
                alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">
    @else
        {{ $partner->name }} 
    @endif
    
    <a class="pull-right btn btn-info text-light" title="editar"
    href="{{ route('partners.edit', ['partner' => $partner]) }}"
            data-toggle="tooltip" data-placement="bottom">
            <i class="ion ion-edit"></i>
        </a>
    </h2>
   

    <div class="card bg-light">
        <div class="card-body">
            <h2 class="card-title text-primary">Productos</h2>
            <x-products.table :products="$products" />
        </div>
    </div>
</div>
@endsection
