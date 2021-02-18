@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Cabecera</h2>
        <form action="{{ route('partners.update', ['partner' => $partner]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-row mb-4">
                <div class="col">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $partner->name }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="image">Logo</label>
                    <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="corporation">Corporación</label>
                <small id="corporationHelp" class="form-text text-muted">Id del comercio electrónico para el pago</small>
                <input type="text" id="corporation" name="corporation" required class="form-control {{ $errors->has('corporation') ? 'is-invalid' : '' }}" value="{{ $partner->corporation }}" placeholder="ej: 77" aria-describedby="corporationHelp">
                @if ($errors->has('corporation'))
                    <div class="invalid-feedback">{{ $errors->first('corporation') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="merchant_code">Merchant Code</label>
                <small id="merchant_codeHelp" class="form-text text-muted">Id del comercio electrónico para el pago</small>
                <input type="text" id="merchant_code" name="merchant_code" required class="form-control {{ $errors->has('merchant_code') ? 'is-invalid' : '' }}" value="{{ $partner->merchant_code }}" placeholder="ej: 055672454" aria-describedby="merchant_codeHelp">
                @if ($errors->has('merchant_code'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_code') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="merchant_key">Merchant Key</label>
                <small id="merchant_keyHelp" class="form-text text-muted">Clave del comercio electrónico para el pago</small>
                <input type="text" id="merchant_key" name="merchant_key" required class="form-control {{ $errors->has('merchant_key') ? 'is-invalid' : '' }}" value="{{ $partner->merchant_key }}" placeholder="ej: RHLPeeZewAnW6qz0V77BFfWPIe4NOjKl" aria-describedby="merchant_keyHelp">
                @if ($errors->has('merchant_key'))
                    <div class="invalid-feedback">{{ $errors->first('merchant_key') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            @if(!$partner->products->count())
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Eliminar
                </button>
            @endif
        </form>
    </div>
    <x-modal :id="'deleteModal'" :title="'Eliminar cabecera'" :footer="''">
        <p>¿Seguro que quieres eliminar la cabecera "{{ $partner->name }}"?</p>
        <form action="{{ route('partners.destroy', ['partner' => $partner]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </x-modal>
@endsection
