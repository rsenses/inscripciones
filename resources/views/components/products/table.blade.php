<div class="table">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Ingresos</th>
                <th>Inscripciones</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="font-weight">{{ $product->name }}</td>
                    <td>{{ $product->start_date->format('d-m-Y / H:i' ) }}</td>
                    <td class="text-right">Pagados: {{ $product->amount }} €</td>
                    <td class="text-right">
                        Sin valorar: {{ $product->new_registrations_count }}<br>
                        Aceptadas: {{ $product->registrations_accepted_count }}<br>
                        Pagadas: {{ $product->paid_registrations_count }}<br>
                        Sin pagar: {{ $product->registrations_accepted_count - $product->paid_registrations_count }}<br>
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
