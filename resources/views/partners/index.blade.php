@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Cabeceras <small><a href="{{ route('partners.create') }}">Nueva cabecera</a></small></h2>
        <x-partners.table :partners="$partners"/>
    </div>
@endsection
