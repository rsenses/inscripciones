@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nuevo Usuario</h2>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="last_name">Apellidos</label>
                <input type="text" id="last_name" name="last_name" required class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" value="{{ old('last_name') }}">
                @if ($errors->has('last_name'))
                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="role">Rol</label>
                    <select id="role" name="role" class="custom-select" required>
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Asistente</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label for="tax_id">DNI</label>
                <input type="text" id="tax_id" name="tax_id" class="form-control {{ $errors->has('tax_id') ? 'is-invalid' : '' }}" value="{{ old('tax_id') }}">
                @if ($errors->has('tax_id'))
                    <div class="invalid-feedback">{{ $errors->first('tax_id') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" id="phone" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="company">Empresa</label>
                <input type="text" id="company" name="company" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" value="{{ old('company') }}">
                @if ($errors->has('company'))
                    <div class="invalid-feedback">{{ $errors->first('company') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="position">Cargo</label>
                <input type="text" id="position" name="position" class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" value="{{ old('position') }}">
                @if ($errors->has('position'))
                    <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
