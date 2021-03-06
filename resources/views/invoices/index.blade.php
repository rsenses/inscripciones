@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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

        <div class="card bg-light">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <h3 class="card-title text-primary">Facturas pendientes de generar</h3>
                    </div>
                    <div class="col text-right">
                        @if($invoices->count())
                            <a href="{{ route('invoices.export') }}" class="btn btn-primary" onclick="return confirm('Seguro que quieres generar el archivo de facturación?');">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                Exportar
                            </a>
                        @endif
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#importModal">
                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                            Importar
                        </button>
                    </div>
                </div>
                @if($invoices->count())
                    <x-invoices.table :invoices="$invoices" :toggle="false"/>
                @else
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-info">Ninguna compra pendiente de facturar en estos momentos.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card bg-light mt-5">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <h3 class="card-title text-primary">Facturadas</h3>
                    </div>
                </div>
                <x-invoices.table :invoices="$billed" :toggle="true"/>
            </div>
        </div>

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
                    <button type="submit" form="importForm" class="btn btn-primary pull-right">Importar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
