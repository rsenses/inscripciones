<div class="table table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="60%">Nombre</th>
                <th>Nº Compras Pagadas</th>
                <th>Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
            <tr>
                <td class="font-weight">
                    {{ $campaign->name }}
                </td>
                <td>{{ $campaign->checkouts_count }}</td>
                <td>{{ number_format($campaign->amount, 2, '.', ',') }}€</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>