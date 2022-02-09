<div class="table table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Ingresos</th>
                <th colspan="2">Inscripciones</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="font-weight">
                        {{ $product->name }}<br>
                        <span class="badge badge-info">{{ $product->mode }}</span>
                    </td>
                    <td>{{ $product->start_date->format('d-m-Y / H:i' ) }}</td>
                    <td class="text-right">Pagados: {{ $product->amount }} €</td>
                    <td class="text-right">
                        Sin valorar: {{ $product->new_registrations_count }}<br>
                        Aceptadas: {{ $product->registrations_accepted_count }}<br>
                        <small>Pagadas:</small> {{ $product->registrations_paid_count }}<br>
                        <small>Sin pagar:</small> {{ $product->registrations_pending_count }}<br>
                    </td>
                    <td class="bg-primary text-center">
                        <a class="text-light " href="{{ route('products.show', ['product' => $product]) }}">
                            <i class="ion ion-ios-eye" aria-hidden="true"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
