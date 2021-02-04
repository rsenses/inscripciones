<div class="table">
    <table class="table table-striped">
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
                    <td>{{ $user->tax_id }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->company }}</td>
                    <td>{{ $user->position }}</td>
                    <td>
                        <a href="{{ route('users.show', ['user' => $user]) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
