<div class="table-responsive">
    <table class="table ">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Empresa</th>
                <th colspan="2">Cargo</th>
                
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
                    <td class="bg-primary text-center has-icon">
                        <a class="text-light" href="{{ route('users.show', ['user' => $user]) }}">
                        <i class="ion ion-ios-eye-outline" aria-hidden="true"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
