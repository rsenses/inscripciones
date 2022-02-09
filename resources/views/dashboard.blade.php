@extends('layouts.app')

@section('content')
    <div class="container-fluid">

    <div class="card bg-light mb-5">
      <div class="card-body">
        <h4 class="card-title">Productos activos</h2>
        <div class="table-responsive">
            <x-products.table :products="$products"/>
        </div>
        </p>
      </div>
    </div>


<div class="card bg-light">
  <div class="card-body">
    <h4 class="card-title">Inscripciones pendientes de valorar</h2>
    <div class="table-responsive">
        <x-registrations.table :registrations="$registrations"/>
    </div>
  </div>
</div>
       
    </div>
@endsection
