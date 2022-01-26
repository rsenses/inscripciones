<div class="table">
    <table class="table table-striped table-bordered" {{ $toggle ? 'data-toggle=table' : '' }} data-search="true"  data-locale="es_ES" data-pagination="true" data-page-size="50" data-page-list="[50, 100, all]">
        <thead>
            <tr>
                <th data-field="status" data-sortable="false" data-visible="true">Status</th>
                <th data-field="payment" data-sortable="false">Pago</th>
                <th data-field="product" data-sortable="true">Producto</th>
                <th data-field="user" data-sortable="true">Usuario</th>
                <th data-field="invoice" data-sortable="false">Facturación</th>
                <th data-field="created_at" data-sortable="true">Fecha de compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr class="{{ $invoice->checkout->status === 'paid' ? 'table-success' : ($invoice->checkout->status === 'pending' ? 'table-warning' : 'table-danger') }}">
                    <td>
                        {{ $invoice->checkout->status == 'paid' ? 'Pagada' : ($invoice->checkout->status === 'pending' ? 'Pendiente' : 'Cancelada') }}
                    </td>
                    <td>
                        {{ $invoice->checkout->amount }} €<br>
                        <span class="badge badge-info">{{ $invoice->checkout->method == 'card' ? 'Tarjeta' : 'Transferencia' }} {{ $invoice->checkout->id }}</span><br>
                        {!! $invoice->number ? '<small class="text-info">Fctr.:</small> ' . $invoice->number : '' !!}
                    </td>
                    <td>
                        @foreach ($invoice->checkout->products->groupBy('id') as $product)
                            <span class="text-info">{{ $product->count() }} x</span> {{ $product[0]->name }} <span class="text-uppercase">{{ $product[0]->mode }}</span><br>
                        @endforeach
                    </td>
                    <td>
                        {{ $invoice->checkout->user->full_name }}<br>
                        <a href="mailto:{{ $invoice->checkout->user->email }}">{{ $invoice->checkout->user->email }}</a>
                    </td>
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
