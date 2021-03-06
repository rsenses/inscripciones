<div class="table">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Empresa</th>
                <th>Cargo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-right">{{ $user->tax_id }}</td>
                    <td class="text-right">{{ $user->phone }}</td>
                    <td>{{ $user->company }}</td>
                    <td>{{ $user->position }}</td>
                    <td class="bg-primary text-center">
                        <a class="text-light" href="{{ route('users.show', ['user' => $user]) }}">
                        <i class="ion ion-ios-eye" aria-hidden="true"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
