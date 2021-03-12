@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nueva Cabecera</h2>
        <div class="card bg-light">
        <div class="card-body">
        <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row align-items-end mb-4">
                <div class="col">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" autofocus required class="form-control form-control-lg{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                
                <div class="col">

                    <input type="file" id="image" name="image"
                            class="custom-file-input form-control-lg{{ $errors->has('image') ? 'is-invalid' : '' }}"
                            aria-describedby="imageHelp">
                        <label class="custom-file-label form-control-lg" for="exampleInputFile"> Selecciona un archivo
                            de imagen</label>
                        @if($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                </div>
            </div>
            <div class="form-group">
                    <label for="url_payment">URL de pago</label>
                    <input type="text" id="url_payment" name="url_payment" required class="form-control form-control-lg{{ $errors->has('url_payment') ? 'is-invalid' : '' }}" value="{{ old('url_payment') }}">
                    @if ($errors->has('url_payment'))
                        <div class="invalid-feedback">{{ $errors->first('url_payment') }}</div>
                    @endif
                </div>

                <div class="form-row mb-4">
                <div class="col-3">
                <label for="corporation">Corporation</label>
                <small id="corporationHelp" class="form-text text-muted">Id del comercio electrónico para el pago</small>
                <input type="text" id="corporation" name="corporation" required class="form-control form-control-lg{{ $errors->has('corporation') ? 'is-invalid' : '' }}" value="{{ old('corporation') }}" placeholder="ej: 77" aria-describedby="corporationHelp">
                @if ($errors->has('corporation'))
                    <div class="invalid-feedback">{{ $errors->first('corporation') }}</div>
                @endif
            </div>
            <div class="col-3">
                <label for="merchant_code">Merchant Code</label>
                <small id="merchant_codeHelp" class="form-text text-muted">Id del comercio electrónico para el pago</small>
                <input type="text" id="merchant_code" name="merchant_code" required class="form-control form-control-lg{{ $errors->has('merchant_code') ? 'is-invalid' : '' }}" value="{{ old('merchant_code') }}" placeholder="ej: 055672454" aria-describedby="merchant_codeHelp">
                @if ($errors->has('merchant_code'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_code') }}</div>
                @endif
            </div>
            <div class="col-6">
                <label for="merchant_key">Merchant Key</label>
                <small id="merchant_keyHelp" class="form-text text-muted">Clave del comercio electrónico para el pago</small>
                <input type="text" id="merchant_key" name="merchant_key" required class="form-control form-control-lg{{ $errors->has('merchant_key') ? 'is-invalid' : '' }}" value="{{ old('merchant_key') }}" placeholder="ej: RHLPeeZewAnW6qz0V77BFfWPIe4NOjKl" aria-describedby="merchant_keyHelp">
                @if ($errors->has('merchant_key'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_key') }}</div>
                @endif
            </div>
                </div>

            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
        </form>

        </div>
        </div>

    </div>
@endsection
