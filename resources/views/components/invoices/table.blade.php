<div class="table">
    <table class="table table-stripe table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Facturación</th>
                <th>Fecha de compra</th>
                <th>Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->checkout->product->name }}</td>
                    <td>{{ $invoice->checkout->user->full_name }}</td>
                    <td>
                        {{ $invoice->address->name }}<br>
                        {{ $invoice->address->tax_type }}: {{ $invoice->address->tax_id }}<br>
                        {{ $invoice->address->full_address }}
                    </td>
                    <td>{{ $invoice->checkout->created_at->format('d-m-Y / H:i:s' ) }}</td>
                    <td class="text-right">{{ $invoice->checkout->amount }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
