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
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $registration)
                <tr>
                    @if($showProduct)
                        <td>{{ $registration->product->name }}</td>
                    @endif
                    <td>{{ $registration->created_at }}</td>
                    <td>{{ $registration->user->full_name }}</td>
                    <td>{{ $registration->user->company }}</td>
                    <td>{{ $registration->user->position }}</td>
                    <td><a href="{{ route('registrations.show', ['registration' => $registration]) }}">ver</a></td>
                    @if(!$showProduct)
                        <td>
                            @if($registration->status !== 'cancelled' && $registration->status !== 'denied')
                                <a href="#0" data-toggle="modal" data-target="#actionsModal{{ $index }}">acciones</a>
                                <x-modal :id="'actionsModal' . $index" :title="'Acciones sobre la inscripción'" :footer="''">
                                    @if($registration->status === 'new')
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST">
                                                    <input type="hidden" name="action" value="accept">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirmar solicitud</button>
                                                </form>
                                            </div>
                                            <div class="col text-right">
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST">
                                                    <input type="hidden" name="action" value="deny">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Denegar solicitud</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    @if($registration->status === 'paid' || $registration->status === 'accepted')
                                        <div class="row">
                                            <div class="col">
                                                @if($registration->status === 'accepted')
                                                    <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST">
                                                        <input type="hidden" name="action" value="pay">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Confirmar pago</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col text-right">
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST">
                                                    <input type="hidden" name="action" value="cancel">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Cancelar compra</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </x-modal>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
