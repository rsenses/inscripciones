<div class="table">
    <table class="table table-striped" {{ $showProduct ? '' : 'data-toggle=table' }} data-search="true" data-show-export="true" data-export-data-type="basic" data-export-types="['csv']" data-locale="es_ES">
        <thead>
            <tr>
                @if($showProduct)
                    <th data-field="product" data-sortable="true">Producto</th>
                @endif
                <th data-field="created_at" data-sortable="true">Fecha</th>
                <th data-field="full_name" data-sortable="true">Nombre</th>
                <th data-field="company" data-sortable="true">Empresa</th>
                <th data-field="position" data-sortable="true">Cargo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
                <tr>
                    @if($showProduct)
                        <td>{{ $registration->product->name }}</td>
                    @endif
                    <td>{{ $registration->created_at }}</td>
                    <td>{{ $registration->user->full_name }}</td>
                    <td>{{ $registration->user->company }}</td>
                    <td>{{ $registration->user->position }}</td>
                    <td><a href="{{ route('registrations.show', ['registration' => $registration]) }}">ver</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
