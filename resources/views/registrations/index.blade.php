@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-3"> 
            <a class="btn btn-primary text-white pull-right d-block" data-toggle="tooltip" data-placement="bottom" title="Crear nueva" href="{{ route('registrations.create') }}">
                <i class="ion ion-plus"></i>
            </a>
            <div class="clearfix"></div>
        </div>

        <div class="card bg-white">
            <div class="card-body">
            <h4 class="card-title">Inscripciones</h2>
            <x-registrations.table :registrations="$registrations"/>
            </div>
        </div>
        
    </div>
@endsection
