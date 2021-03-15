@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $registration->product->name }} <small class="text-xs">
        <a class="btn btn-info pull-right text-light" href="{{ route('registrations.edit', ['registration' => $registration]) }}">
            <i class="ion ion-edit" aria-hidden="true"></i>
        </a></small>

    </h2>
    <div class="card text-white bg-light">
        <div class="card-body">
            <div class="table">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Asistente</td>
                        <td>{{ $registration->user->full_name }}
                            {{ '<' . $registration->user->email . '>' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de inscripción</td>
                        <td>{{ $registration->created_at->format('d-m-Y / H:i' ) }}</td>
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
    </div>
</div>
@endsection
