@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nueva Cabecera</h2>
        <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-4">
                <div class="col">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="url_payment">URL de pago</label>
                    <input type="text" id="url_payment" name="url_payment" required class="form-control {{ $errors->has('url_payment') ? 'is-invalid' : '' }}" value="{{ old('url_payment') }}">
                    @if ($errors->has('url_payment'))
                        <div class="invalid-feedback">{{ $errors->first('url_payment') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="image">Logo</label>
                    <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" required>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="merchant_code">Merchant Code</label>
                <small id="merchant_codeHelp" class="form-text text-muted">Id del comercio electrónico para el pago</small>
                <input type="text" id="merchant_code" name="merchant_code" required class="form-control {{ $errors->has('merchant_code') ? 'is-invalid' : '' }}" value="{{ old('merchant_code') }}" placeholder="ej: 055672454" aria-describedby="merchant_codeHelp">
                @if ($errors->has('merchant_code'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_code') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="merchant_key">Merchant Key</label>
                <small id="merchant_keyHelp" class="form-text text-muted">Clave del comercio electrónico para el pago</small>
                <input type="text" id="merchant_key" name="merchant_key" required class="form-control {{ $errors->has('merchant_key') ? 'is-invalid' : '' }}" value="{{ old('merchant_key') }}" placeholder="ej: RHLPeeZewAnW6qz0V77BFfWPIe4NOjKl" aria-describedby="merchant_keyHelp">
                @if ($errors->has('merchant_key'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_key') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
