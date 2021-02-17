@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Producto</h2>
        <form action="{{ route('products.update', ['product' => $product]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $product->name }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="url">Url</label>
                <small id="urlHelp" class="form-text text-muted">Url de la web del producto</small>
                <input type="text" id="url" name="url" required class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" placeholder="ej: https://foro.expansion.com" aria-describedby="urlHelp" value="{{ $product->url }}">
                @if ($errors->has('url'))
                    <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col col-sm-4">
                    <label for="partners">Cabeceras</label><br>
                    <select class="selectpicker" multiple id="partners" name="partners[]">
                        @foreach($partners as $partner)
                            <option value={{ $partner->id }} {{ in_array($partner->id, $product->partners->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col col-sm-8">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" cols="30" rows="10" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $product->description }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="price">Precio</label>
                    <input type="text" placeholder="Decimal separado por punto, ej: 200.50" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ $product->price }}">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="mode">Modalidad</label>
                    <select id="mode" name="mode" required class="custom-select {{ $errors->has('mode') ? 'is-invalid' : '' }}">
                        <option value="presencial" {{ $product->mode === 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="online" {{ $product->mode === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @if ($errors->has('mode'))
                        <div class="invalid-feedback">{{ $errors->first('mode') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" aria-describedby="imageHelp">
                    <small id="imageHelp" class="form-text text-muted">Se usa para el envío de emails, ancho de 600px, peso máximo 300kb</small>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="place">Lugar de celebración</label>
                <input type="text" name="place" id="place" class="form-control {{ $errors->has('place') ? 'is-invalid' : '' }}" value="{{ $product->place }}">
                @if ($errors->has('place'))
                    <div class="invalid-feedback">{{ $errors->first('place') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="start_date">Fecha de inicio</label>
                    <input type="text" name="start_date" id="start_date" required class="form-control datetime {{ $errors->has('start_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ $product->start_date }}">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="end_date">Fecha de fin</label>
                    <input type="text" id="end_date" name="end_date" required class="form-control datetime {{ $errors->has('end_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ $product->end_date }}">
                    @if ($errors->has('end_date'))
                        <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            @if(!$product->registrations()->count())
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Eliminar
                </button>
            @endif
        </form>
    </div>
    <x-modal :id="'deleteModal'" :title="'Eliminar producto'" :footer="''">
        <p>¿Seguro que quieres eliminar el producto "{{ $product->name }}"?</p>
        <form action="{{ route('products.destroy', ['product' => $product]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </x-modal>
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
            document.querySelectorAll('.selectpicker').selectpicker();
        }
    </script>
@endsection
