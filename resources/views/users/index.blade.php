@extends('layouts.app')

@section('content')
<div class="container-fluid">



    <div class="card bg-white">
        <img class="card-img-top"
             src="holder.js/100px180/"
             alt="">
        <div class="card-body">
            <h4 class="card-title"> <i class="fas fa-user-friends"></i> Usuarios</h4>
                <div class="mb-1 d-flex justify-content-between">
                    @if($role === 'admin')
                        <a href="{{ route('users.index', ['role' => 'customer']) }}"
                           class="btn btn-white text-primary border border-primary">Asistentes <i
                               class="lni lni-consulting"></i></a>
                    @else
                        <a href="{{ route('users.index', ['role' => 'admin']) }}"
                           class="btn btn-white text-primary border border-primary"><i class="fas fa-user-tie"></i>
                            Administradores <i class="lni lni-consulting"></i></a>
                    @endif
                    <a class="btn btn-white text-primary border border-primary ml-2"
                       data-toggle="tooltip"
                       data-placement="bottom"
                       title="Crear nuevo"
                       href="{{ route('users.create') }}">
                        Nuevo <i class="ion ion-plus"></i>
                    </a>
                </div>
            <x-users.table :users="$users" />
        </div>
    </div>

</div>
@endsection
