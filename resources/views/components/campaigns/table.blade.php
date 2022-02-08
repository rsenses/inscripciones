<div class="table">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cabecera</th>
                <th>Imagen</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
                <tr>
                    <td class="font-weight">
                        {{ $campaign->name }}<br>
                    </td>
                    <td>{{ $campaign->partner->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="Imagen {{ $campaign->name }}" class="img-fuid" style="max-width: 200px;">
                    </td>
                    <td class="bg-primary text-center">
                        <a class="text-light " href="{{ route('campaigns.edit', ['campaign' => $campaign]) }}">
                            <i class="ion ion-edit" aria-hidden="true"></i> Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
