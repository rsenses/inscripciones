@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $user->full_name }} <small class="text-xs"><a href="{{ route('users.edit', ['user' => $user]) }}">Editar</a></small></h2>
        <div class="table">
            <table class="table table-striped">
                <tr>
                    <td>Email</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Teléfono</td>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <td>Empresa</td>
                    <td>{{ $user->company }}</td>
                </tr>
                <tr>
                    <td>Cargo</td>
                    <td>{{ $user->position }}</td>
                </tr>
            </table>
        </div>
        <hr class="my-5">
        <h3>Inscripciones</h3>
        <x-registrations.table :registrations="$user->registrations"/>
    </div>
@endsection
