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

        <div class="row mb-4">
            <div class="col">
                <div class="form-group">
                <p>Filtrar por campaña.</p>
                <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = '{{ URL::current() }}?campaign=' + this.options[this.selectedIndex].value);">
                    <option selected value="0">-- Sin filtro --</option>
                    @foreach ($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ $campaign->id == $campaignId ? 'selected' : '' }}>{{ $campaign->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
        </div>

        <div class="card bg-white">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">Facturas pendientes de generar</h3>
                    </div>
                    <div class="col text-right">
                        @if($invoices->count())
                            <a href="{{ route('invoices.export') }}" class="btn btn-primary mb-3" onclick="return confirm('Seguro que quieres generar el archivo de facturación?');">

                                Exportar <i class="lni lni-download"></i>
                            </a>
                        @endif
                        <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#importModal">
                            Importar <i class="lni lni-upload"></i>
                        </button>
                    </div>
                </div>
                @if($invoices->count())
                    <x-invoices.table :invoices="$invoices" :toggle="true"/>
                @else
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-info">Ninguna compra pendiente de facturar en estos momentos.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card bg-white mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">Facturadas</h3>
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
