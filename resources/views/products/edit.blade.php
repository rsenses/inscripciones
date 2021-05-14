@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Editar Producto</h2>


    <div class="card bg-light">
        <div class="card-body">
            <form
                action="{{ route('products.update', ['product' => $product]) }}"
                method="POST" enctype="multipart/form-data" id="js-upload-form">
                @method('PUT')
                @csrf
                <div class="form-row mb-4">
                <div class="col-1">
                <label for="name">Id.</label>
                    <input type="text" id="product_id" name="product_id" readonly="readonly" required
                        class="text-right form-control form-control-lg {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                        value="{{ $product->product_id }}">
                </div>
                <div class="col-11">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" autofocus required
                        class=" form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ $product->name }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                </div>
                
                <div class="form-group">
                    <label for="url">Url</label>
                    <small id="urlHelp" class="form-text text-muted">Url de la web del producto</small>
                    <input type="text" id="url" name="url" required
                        class=" form-control form-control-lg {{ $errors->has('url') ? 'is-invalid' : '' }}"
                        placeholder="ej: https://foro.expansion.com" aria-describedby="urlHelp"
                        value="{{ $product->url }}">
                    @if($errors->has('url'))
                        <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                    @endif
                </div>
                <div class="form-row mb-4">
                    <div class="col col-sm-4">
                        <label>Selecciona una imagen</label>
                        <div class="card">
                            <div class="card-body">

                                <input type="file" id="image" name="image"
                                    class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                    aria-describedby="imageHelp">
                                <label class="custom-file-label" for="exampleInputFile"> Selecciona un archivo</label>

                                <small id="imageHelp" class="form-text text-muted">Se usa para el envío de emails, ancho
                                    de 600px, peso máximo 300kb</small>
                                @if($errors->has('image'))
                                    <div class="invalid-feedback">{{ $errors->first('image') }}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-8">
                        <label for="description">Descripción</label>
                        <textarea id="description" name="description" cols="30" rows="10"
                            class=" form-control form-control-lg {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $product->description }}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-4">
                    <div class="col">
                        <label for="partners">Cabeceras</label><br>
                        <select class="form-control form-control-lg selectpicker" multiple id="partners"
                            name="partners[]">
                            @foreach($partners as $partner)
                                <option value={{ $partner->id }}
                                    {{ in_array($partner->id, $product->partners->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="price">Precio</label>
                        <input type="text" placeholder="Decimal separado por punto, ej: 200.50" name="price" id="price"
                            class="text-right form-control form-control-lg {{ $errors->has('price') ? 'is-invalid' : '' }}"
                            value="{{ $product->price }}">
                        <span class="input-group-addon">€</span>
                        @if($errors->has('price'))
                            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <label for="mode">Modalidad</label>
                        <select id="mode" name="mode" required
                            class="custom-select form-control-lg {{ $errors->has('mode') ? 'is-invalid' : '' }}">
                            <option value="presencial"
                                {{ $product->mode === 'presencial' ? 'selected' : '' }}>
                                Presencial</option>
                            <option value="online"
                                {{ $product->mode === 'online' ? 'selected' : '' }}>
                                Online</option>
                        </select>
                        @if($errors->has('mode'))
                            <div class="invalid-feedback">{{ $errors->first('mode') }}</div>
                        @endif
                    </div>

                </div>
                <div class="form-group">
                    <label for="place">Lugar de celebración</label>
                    <input type="text" name="place" id="place"
                        class=" form-control form-control-lg {{ $errors->has('place') ? 'is-invalid' : '' }}"
                        value="{{ $product->place }}">
                    @if($errors->has('place'))
                        <div class="invalid-feedback">{{ $errors->first('place') }}</div>
                    @endif
                </div>
                <div class="form-row mb-4">
                    <div class="col">
                        <label for="start_date">Fecha de inicio</label>
                        <input type="text" name="start_date" id="start_date" required
                            class=" form-control form-control-lg datetime {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                            placeholder="Formato aaaa-mm-dd hh:mm" value="{{ $product->start_date }}">
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <label for="end_date">Fecha de fin</label>
                        <input type="text" id="end_date" name="end_date" required
                            class=" form-control form-control-lg datetime {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                            placeholder="Formato aaaa-mm-dd hh:mm" value="{{ $product->end_date }}">
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                @if(!$product->registrations()->count())
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        Eliminar
                    </button>
                @endif
            </form>
        </div>
    </div>


</div>
<x-modal :id="'deleteModal'" :title="'Eliminar producto'" :footer="''">
    <p>¿Seguro que quieres eliminar el producto "{{ $product->name }}"?</p>
    <form
        action="{{ route('products.destroy', ['product' => $product]) }}"
        method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger pull-right">Eliminar</button>
    </form>
</x-modal>
@endsection

@section('scripts')
<script>
    window.onload = function (e) {
        document.querySelectorAll('.datetime').forEach(function (el) {
            new Cleave(el, {
                delimiters: ['-', '-', ' ', ':'],
                blocks: [4, 2, 2, 2, 2]
            });
        });
        //document.querySelectorAll('.selectpicker').selectpicker();
        $('#image').change(
            function (e) {
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            }
        )
        $('#price').keyup(
            function (e) {
                console.log(e.target.value.replace(/,/g, '.'))
            }
        )
    }

</script>
@endsection
