@extends('layouts.app')

@section('content')
    <div class="container">

    <div class="card text-white bg-light mb-5">
      <div class="card-body">
        <h2 class="card-title text-primary">Productos activos</h2>
        <div class="table-responsive">
            <x-products.table :products="$products"/>
        </div>
        </p>
      </div>
    </div>


<div class="card text-white bg-light">
  <div class="card-body">
    <h2 class="card-title text-primary">Últimas inscripciones</h2>
    <div class="table-responsive">
        <x-registrations.table :registrations="$registrations"/>
    </div>
  </div>
</div>
       
    </div>
@endsection
