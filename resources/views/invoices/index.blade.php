@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Facturación</h2>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {!! session()->get('success') !!}
            </div>
        @endif
        @if(session()->has('danger'))
            <div class="alert alert-danger">
                {!! session()->get('danger') !!}
            </div>
        @endif
        <div class="row mb-4">
            <div class="col">
                <h3>Facturas pendientes de generar</h3>
            </div>
            <div class="col text-right">
                <a href="{{ route('invoices.export') }}" class="btn btn-primary">Exportar</a>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importModal">Importar</button>
            </div>
        </div>
        <x-invoices.table :invoices="$invoices"/>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Importar facturas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="importForm" method="POST" action="{{ route('invoices.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="importBills">Archivo CSV</label>
                            <input type="file" class="form-control-file" id="importBills" name="import">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="importForm" class="btn btn-primary">Importar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
