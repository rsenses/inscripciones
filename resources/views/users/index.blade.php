@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="mb-3">
    @if($role === 'admin')
                <a href="{{ route('users.index', ['role' => 'customer']) }}" class="btn btn-secondary">Asistentes</a>
            @else
                <a href="{{ route('users.index', ['role' => 'admin']) }}" class="btn btn-primary"><i class="fas fa-user-tie"></i> Administradores</a>
            @endif
    <a class="btn btn-primary text-white pull-right d-block" data-toggle="tooltip" data-placement="bottom" title="Crear nuevo" href="{{ route('users.create') }}">
            <i class="ion ion-plus"></i>
        </a>
        <div class="clearfix"></div>
    </div>

    
    <div class="card bg-light">
      <img class="card-img-top" src="holder.js/100px180/" alt="">
      <div class="card-body">
        <h4 class="card-title text-primary"> <i class="fas fa-user-friends"></i> Usuarios</h4>
        <x-users.table :users="$users"/>
      </div>
    </div>
       
    </div>
@endsection
