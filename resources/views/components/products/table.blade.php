<div class="table">
    <table class="table table-striped">
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
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->start_date }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->registrations_count }}</td>
                    <td>
                        <a href="{{ route('products.show', ['product' => $product]) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
