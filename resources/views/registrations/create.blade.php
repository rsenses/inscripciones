@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nueva Inscripción</h2>
        <form action="{{ route('registrations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_id">Producto</label><br>
                <select id="product_id" name="product_id" required class="selectpicker {{ $errors->has('product_id') ? 'is-invalid' : '' }}" data-live-search="true">
                    <option disabled selected></option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
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
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->full_name }} {{ '<' . $user->email . '>' }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = function (e) {
            $('.selectpicker').selectpicker();
        }
    </script>
@endsection
