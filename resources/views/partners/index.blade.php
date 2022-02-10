@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card bg-white">
        <div class="card-body">
            <h4 class="card-title">Cabeceras
                  <a class="btn btn-white text-primary border border-primary pull-right d-block mb-1
                     data-toggle="tooltip"
                     data-placement="bottom"
                     title="Crear nueva"
                     href="{{ route('partners.create') }}">
                      Nuevo <i class="ion ion-plus"></i>
                  </a>
            </h4>
             <div class="clearfix"></div>
            <x-partners.table :partners="$partners" />
        </div>
    </div>
</div>
@endsection
