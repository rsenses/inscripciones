@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        @if(Auth::user()->role === 'superadmin')
            <a class="btn btn-primary text-white pull-right d-block" data-toggle="tooltip" data-placement="bottom" title="Crear nueva" href="{{ route('campaigns.create') }}">
                <i class="ion ion-plus"></i>
            </a>
        @endif
        <div class="clearfix"></div>
    </div>


    <div class="card bg-light">
        <div class="card-body">
        <h4 class="card-title">Campañas</h2>
            <x-campaigns.table :campaigns="$campaigns" />
        </div>
    </div>

</div>
@endsection
