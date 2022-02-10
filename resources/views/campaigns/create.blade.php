@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Nueva Campaña</h2>
    <div class="card bg-white">
        <div class="card-body">
            <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-4">
                    <div class="col-12">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" autofocus required class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" onkeyup="updateInput(this.value)">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="folder">Carpeta</label>
                    <small id="folderHelp" class="form-text text-muted">Carpeta para almacenar datos de campaña. Se genera automáticamente</small>
                    <input type="text" id="folder" name="folder" required readonly class="form-control form-control-lg" aria-describedby="folderHelp">
                    @if ($errors->has('folder'))
                    <div class="invalid-feedback">{{ $errors->first('folder') }}</div>
                    @endif
                </div>
                <div class="form-row">
                    <div class="col col-sm-4">
                        <label>Selecciona una imagen</label>
                        <div class="card">
                            <div class="card-body">

                                <input type="file" id="image" name="image" class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" aria-describedby="imageHelp">
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
                </div>
                <div class="form-row mb-4">
                    <div class="col">
                        <label for="partner_id">Cabeceras</label><br>
                        <select class="form-control form-control-lg selectpicker" id="partner_id" name="partner_id">
                            @foreach($partners as $partner)
                            <option value={{ $partner->id }} {{ old('partners') && in_array($partner->id, old('partners')) ? 'selected' : '' }}>{{ $partner->name }}</option>
                            @endforeach
                        </select>
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
        document.querySelectorAll('.datetime').forEach(function (el) {
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
    function convertToSlug(Text) {
        return Text.toLowerCase()
            .replace(/ /g, '')
            .replace(/[^\w-]+/g, '');
    }
    function updateInput(name){
        document.getElementById("folder").value = convertToSlug(name);
    }
</script>
@endsection