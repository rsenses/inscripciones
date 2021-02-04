@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Inscripciones <small><a href="{{ route('registrations.create') }}">Nueva inscripción</a></small></h2>
        <x-registrations.table :registrations="$registrations"/>
    </div>
@endsection
