<div class="table">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>PVP</th>
                <th>Inscripciones</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="font-weight">{{ $product->name }}</td>
                    <td>{{ $product->start_date->format('d-m-Y / H:i' ) }}</td>
                    <td class="text-right">{{ $product->price }} €</td>
                    <td class="text-right">{{ $product->registrations_count }}</td>
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
