@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>{{ $user->full_name }} <a class="pull-right btn btn-info text-light" title="editar"
            href="{{ route('users.edit', ['user' => $user]) }}"
            data-toggle="tooltip" data-placement="bottom">
            <i class="ion ion-edit"></i>
        </a></h2>

<div class="card bg-white">

  <div class="card-body">
  <div class="table-responsive">
        <table class="table ">
            <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <td>Empresa</td>
                <td>{{ $user->company }}</td>
            </tr>
            <tr>
                <td>Cargo</td>
                <td>{{ $user->position }}</td>
            </tr>
        </table>
    </div>
  </div>
</div>

    <hr class="my-5">
    <div class="card bg-white">
      <img class="card-img-top" src="holder.js/100px180/" alt="">
      <div class="card-body">
        <h4 class="card-title">Inscripciones</h4>
        <x-registrations.table :registrations="$user->registrations" />
      </div>
    </div>

</div>
@endsection
