<div class="table-responsive">
    <table class="table ">
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
                    <td class="ext-center has-icon">
                        <a class="text-primary t"
                           href="{{ route('campaigns.edit', ['campaign' => $campaign]) }}">
                            <i class="lni lni-pencil-alt"></i> Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
