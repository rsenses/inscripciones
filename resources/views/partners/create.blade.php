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
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
