@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-3"> 
            <a class="btn btn-primary text-white pull-right d-block" data-toggle="tooltip" data-placement="bottom" title="Crear nueva" href="{{ route('registrations.create') }}">
                <i class="ion ion-plus"></i>
            </a>
            <div class="clearfix"></div>
        </div>

        <div class="card bg-light">
            <div class="card-body">
            <h2 class="card-title text-primary">Inscripciones</h2>
            <x-registrations.table :registrations="$registrations"/>
            </div>
        </div>
        
    </div>
@endsection
