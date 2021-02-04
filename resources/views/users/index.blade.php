@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Usuarios <small><a href="{{ route('users.create') }}">Nuevo usuario</a></small></h2>
        <p>
            @if($role === 'admin')
                <a href="{{ route('users.index', ['role' => 'customer']) }}" class="btn btn-info">Asistentes</a>
            @else
                <a href="{{ route('users.index', ['role' => 'admin']) }}" class="btn btn-info">Administradores</a>
            @endif
        </p>
        <x-users.table :users="$users"/>
    </div>
@endsection
