@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nuevo Producto</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">>
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-row">
                <div class="col col-sm-4">
                    <label for="partners">Cabeceras</label><br>
                    <select class="selectpicker" multiple id="partners" name="partners[]">
                        @foreach($partners as $partner)
                            <option value={{ $partner->id }} {{ old('partners') && in_array($partner->id, old('partners')) ? 'selected' : '' }}>{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col col-sm-8">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" cols="30" rows="10" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="price">Precio</label>
                    <input type="text" placeholder="Decimal separado por punto, ej: 200.50" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="mode">Modalidad</label>
                    <select id="mode" name="mode" required class="custom-select {{ $errors->has('mode') ? 'is-invalid' : '' }}">
                        <option value="presencial" {{ old('mode') === 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @if ($errors->has('mode'))
                        <div class="invalid-feedback">{{ $errors->first('mode') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="image">Imagen</label>
                    <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" required aria-describedby="imageHelp">
                    <small id="imageHelp" class="form-text text-muted">Se usa para el envío de emails, ancho de 600px, peso máximo 300kb</small>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="place">Lugar de celebración</label>
                <input type="text" name="place" id="place" class="form-control {{ $errors->has('place') ? 'is-invalid' : '' }}" value="{{ old('place') }}">
                @if ($errors->has('place'))
                    <div class="invalid-feedback">{{ $errors->first('place') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="start_date">Fecha de inicio</label>
                    <input type="text" name="start_date" id="start_date" required class="form-control datetime {{ $errors->has('start_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ old('start_date') }}">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="end_date">Fecha de fin</label>
                    <input type="text" id="end_date" name="end_date" required class="form-control datetime {{ $errors->has('end_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ old('end_date') }}">
                    @if ($errors->has('end_date'))
                        <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = function (e) {
            document.querySelectorAll('.datetime').forEach(function(el) {
                new Cleave(el, {
                    delimiters: ['-', '-', ' ', ':'],
                    blocks: [4, 2, 2, 2, 2]
                });
            });
        }
    </script>
@endsection
