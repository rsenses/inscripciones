@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $registration->product->name }} <small class="text-xs"><a href="{{ route('registrations.edit', ['registration' => $registration]) }}">Editar</a></small></h2>
        <div class="table">
            <table class="table table-striped">
                <tr>
                    <td>Asistente</td>
                    <td>{{ $registration->user->full_name }} {{ '<' . $registration->user->email . '>' }}</td>
                </tr>
                <tr>
                    <td>Fecha de inscripción</td>
                    <td>{{ $registration->created_at }}</td>
                </tr>
                <tr>
                    <td>Tipo</td>
                    <td>{{ $registration->type }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $registration->status }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
