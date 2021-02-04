@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Inscripción</h2>
        <form action="{{ route('registrations.update', ['registration' => $registration]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="product_id">Producto</label><br>
                <select id="product_id" name="product_id" required class="selectpicker {{ $errors->has('product_id') ? 'is-invalid' : '' }}" data-live-search="true">
                    <option disabled selected></option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $registration->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('product_id'))
                    <div class="invalid-feedback">{{ $errors->first('product_id') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="user_id">Usuario</label>
                <small id="userHelp" class="form-text text-muted">Si no existe el usuario, <a href="{{ route('users.create') }}">pincha aquí</a> para crear uno nuevo.</small>
                <select id="user_id" name="user_id" required class="selectpicker {{ $errors->has('user_id') ? 'is-invalid' : '' }}" aria-describedby="userHelp" data-live-search="true">
                    <option disabled selected></option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $registration->user_id == $user->id ? 'selected' : '' }}>{{ $user->full_name }} {{ '<' . $user->email . '>' }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                Eliminar
            </button>
        </form>
    </div>
    <x-modal :id="'deleteModal'" :title="'Eliminar inscripción'" :footer="''">
        <p>¿Seguro que quieres eliminar la inscripción de {{ $registration->user->full_name }} a {{ $registration->product->name }}?</p>
        <form action="{{ route('registrations.destroy', ['registration' => $registration]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </x-modal>
@endsection

@section('scripts')
    <script>
        window.onload = function (e) {
            $('.selectpicker').selectpicker();
        }
    </script>
@endsection
