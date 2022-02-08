@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2>Nuevo Producto</h2>
        <div class="card bg-light">
          <div class="card-body">
          <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-4">
            <div class="col-1">
                <label for="name">Id.</label>
                    <input type="text" id="product_id" name="product_id" required
                        class="text-right form-control form-control-lg {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                        value="{{ old('product_id') }}">
                </div>
                <div class="col-11">
            
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" autofocus required class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            </div>
            <div class="form-group">
                <label for="url">Url</label>
                <small id="urlHelp" class="form-text text-muted">Url de la web del producto</small>
                <input type="text" id="url" name="url" required class="form-control form-control-lg {{ $errors->has('url') ? 'is-invalid' : '' }}" value="{{ old('url') }}" placeholder="ej: https://foro.expansion.com" aria-describedby="urlHelp">
                @if ($errors->has('url'))
                    <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                @endif
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" cols="30" rows="10" class="form-control form-control-lg {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="campaign_id">Campaña</label><br>
                    <select class="form-control form-control-lg" id="campaign_id"
                        name="campaign_id">
                        @foreach($campaigns as $campaign)
                            <option value={{ $campaign->id }}>
                                {{ $campaign->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('campaign_id'))
                        <div class="invalid-feedback">{{ $errors->first('campaign_id') }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <label for="price">Precio</label>
                    <input type="text" placeholder="Decimal separado por punto, ej: 200.50" name="price" class="text-right form-control form-control-lg {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ old('price') }}">
                    <span class="input-group-addon">€</span>
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="mode">Modalidad</label>
                    <select id="mode" name="mode" required class="form-control-lg  custom-select {{ $errors->has('mode') ? 'is-invalid' : '' }}">
                        <option value="presencial" {{ old('mode') === 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @if ($errors->has('mode'))
                        <div class="invalid-feedback">{{ $errors->first('mode') }}</div>
                    @endif
                </div>

            </div>
            <div class="form-group">
                <label for="place">Lugar de celebración</label>
                <input type="text" name="place" id="place" class="form-control form-control-lg {{ $errors->has('place') ? 'is-invalid' : '' }}" value="{{ old('place') }}">
                @if ($errors->has('place'))
                    <div class="invalid-feedback">{{ $errors->first('place') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="start_date">Fecha de inicio</label>
                    <input type="text" name="start_date" id="start_date" required class="form-control form-control-lg datetime {{ $errors->has('start_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ old('start_date') }}">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="end_date">Fecha de fin</label>
                    <input type="text" id="end_date" name="end_date" required class="form-control form-control-lg datetime {{ $errors->has('end_date') ? 'is-invalid' : '' }}" placeholder="Formato aaaa-mm-dd hh:mm" value="{{ old('end_date') }}">
                    @if ($errors->has('end_date'))
                        <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary text-white pull-right">Guardar</button>
        </form>
          </div>
        </div>

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
            $('#image').change(
            function (e) {
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            }
        )
        }
    </script>
@endsection
