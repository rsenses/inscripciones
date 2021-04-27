<div class="table">
    <table class="table table-striped table-bordered" {{ $toggle ? 'data-toggle=table' : '' }} data-search="true"  data-locale="es_ES">
        <thead>
            <tr>
                <th data-field="status" data-sortable="false">Status</th>
                <th data-field="payment" data-sortable="false">Pago</th>
                <th data-field="product" data-sortable="true">Producto</th>
                <th data-field="user" data-sortable="true">Usuario</th>
                <th data-field="invoice" data-sortable="false">Facturación</th>
                <th data-field="created_at" data-sortable="true">Fecha de compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td class="alert {{ $invoice->checkout->status === 'paid' ? 'alert-succes' : 'alert-danger' }}">
                        <i class="ion-cash" aria-hidden="true"></i>&ensp;
                        {{ $invoice->checkout->status == 'paid' ? 'Pagado' : 'Pendiente' }}
                    </td>
                    <td>
                        {{ $invoice->checkout->amount }} €<br>
                        <span class="badge badge-info">{{ $invoice->checkout->method == 'card' ? 'Tarjeta' : 'Transferencia' }} {{ $invoice->checkout->id }}</span><br>
                        {!! $invoice->number ? '<small class="text-info">Fctr.:</small> ' . $invoice->number : '' !!}
                    </td>
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
