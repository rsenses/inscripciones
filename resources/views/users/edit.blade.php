@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Usuario</h2>
        <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" autofocus required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $user->name }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="last_name">Apellidos</label>
                <input type="text" id="last_name" name="last_name" required class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" value="{{ $user->last_name }}">
                @if ($errors->has('last_name'))
                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                @endif
            </div>
            <div class="form-row mb-4">
                <div class="col">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ $user->email }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="role">Rol</label>
                    <select id="role" name="role" class="custom-select" required>
                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Asistente</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tax_id">DNI</label>
                <input type="text" id="tax_id" name="tax_id" class="form-control {{ $errors->has('tax_id') ? 'is-invalid' : '' }}" value="{{ $user->tax_id }}">
                @if ($errors->has('tax_id'))
                    <div class="invalid-feedback">{{ $errors->first('tax_id') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" id="phone" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ $user->phone }}">
                @if ($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="company">Empresa</label>
                <input type="text" id="company" name="company" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" value="{{ $user->company }}">
                @if ($errors->has('company'))
                    <div class="invalid-feedback">{{ $errors->first('company') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="position">Cargo</label>
                <input type="text" id="position" name="position" class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" value="{{ $user->position }}">
                @if ($errors->has('position'))
                    <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            @if(!$user->registrations->count())
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Eliminar
                </button>
            @endif
        </form>
    </div>
    <x-modal :id="'deleteModal'" :title="'Eliminar usuario'" :footer="''">
        <p>¿Seguro que quieres eliminar el usuario "{{ $user->full_name }}"?</p>
        <form action="{{ route('users.destroy', ['user' => $user]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </x-modal>
@endsection
