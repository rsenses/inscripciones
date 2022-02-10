@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Editar Campaña</h2>


    <div class="card bg-white">
        <div class="card-body">
            <form
                action="{{ route('campaigns.update', ['campaign' => $campaign]) }}"
                method="POST" enctype="multipart/form-data" id="js-upload-form">
                @method('PUT')
                @csrf
                <div class="form-row mb-4">
                    <div class="col-12">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" autofocus 
                            class=" form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ $campaign->name }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
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
                </div>
                <div class="form-row mb-4">
                    <div class="col">
                        <label for="partner_id">Cabeceras</label><br>
                        <select class="form-control form-control-lg" id="partner_id"
                            name="partner_id">
                            @foreach($partners as $partner)
                                <option value={{ $partner->id }}
                                    {{ $partner->id == $campaign->partner_id ? 'selected' : '' }}>
                                    {{ $partner->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('partner_id'))
                            <div class="invalid-feedback">{{ $errors->first('partner_id') }}
                            </div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                @if(!$campaign->products()->count())
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        Eliminar
                    </button>
                @endif
            </form>
        </div>
    </div>


</div>
<x-modal :id="'deleteModal'" :title="'Eliminar campaigno'" :footer="''">
    <p>¿Seguro que quieres eliminar la campaña "{{ $campaign->name }}"?</p>
    <form
        action="{{ route('campaigns.destroy', ['campaign' => $campaign]) }}"
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
        $('#image').change(
            function (e) {
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            }
        )
    }

</script>
@endsection
