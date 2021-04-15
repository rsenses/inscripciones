<div class="table">
    <table class="table table-stripe table-bordered">
        <thead>
            <tr>
                <th>Status</th>
                <th>Pago</th>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Facturación</th>
                <th>Fecha de compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td class="alert {{ $invoice->checkout->status === 'paid' ? 'alert-succes' : 'alert-danger' }}">
                        <i class="ion-cash" aria-hidden="true"></i>&ensp;
                        {{ $invoice->checkout->status == 'paid' ? 'Pagado' : 'Pendiente' }}
                    </td>
                    <td>{{ $invoice->checkout->amount }} €<br><span class="badge badge-info">{{ $invoice->checkout->method == 'card' ? 'Tarjeta' : 'Transferencia' }}</span></td>
                    <td>{{ $invoice->checkout->product->name }}</td>
                    <td>{{ $invoice->checkout->user->full_name }}</td>
                    <td>
                        {{ $invoice->address->name }}<br>
                        {{ $invoice->address->tax_type }}: {{ $invoice->address->tax_id }}<br>
                        {{ $invoice->address->full_address }}
                    </td>
                    <td>{{ $invoice->checkout->created_at->format('d-m-Y / H:i:s' ) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
