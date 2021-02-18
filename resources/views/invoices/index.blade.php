@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Facturación</h2>
        <div class="row mb-4">
            <div class="col">
                <h3>Facturas pendientes de generar</h3>
            </div>
            <div class="col text-right">
                <a href="{{ route('invoices.export') }}" class="btn btn-primary">Exportar</a>
            </div>
        </div>
        <x-invoices.table :invoices="$invoices"/>
    </div>
@endsection
