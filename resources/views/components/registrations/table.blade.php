<div class="table">
    <table class="table table-striped table-bordered" {{ $showProduct ? '' : 'data-toggle=table' }} data-search="true" data-show-export="true" data-export-data-type="basic" data-export-types="['csv']" data-locale="es_ES" data-filter-control="true">
        <thead>
            <tr>
                @if($showProduct)
                    <th data-field="product" data-sortable="true">Producto</th>
                @else
                    <th data-field="status" data-sortable="true" data-filter-control="select">Status</th>
                @endif
                <th data-field="created_at" data-sortable="true">Fecha</th>
                <th data-field="full_name" data-sortable="true">Nombre</th>
                <th data-field="company" data-sortable="true">Empresa</th>
                <th data-field="position" data-sortable="true">Cargo</th>
                <th data-field="email" data-sortable="true">Email</th>
                <th data-field="phone" data-sortable="true">Tlf</th>
                <th data-field="promo" data-sortable="true">Promo</th>
                @if(!$showProduct)
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $registration)
                <tr>
                    @if($showProduct)
                        <td>
                            <a href="{{ route('products.show', ['product' => $registration->product]) }}">
                                {{ $registration->product->name }} <span class="badge badge-info">{{ $registration->product->mode }}</span>
                            </a>
                        </td>
                    @else
                        <td class="alert {{ $registration->status === 'accepted' ? 'alert-info' : ($registration->status === 'paid' ? 'alert-success' : ($registration->status === 'denied' ? 'alert-danger' : ($registration->status === 'cancelled' ? 'alert-warning' : ($registration->status === 'pending' ? 'alert-info' : '')))) }}">
                        {{-- <i class="ion {{ $registration->status === 'accepted' ? 'ion-thumbsup' : ($registration->status === 'paid' ? 'ion-cash' : ($registration->status === 'denied' ? 'ion-thumbsdown' : ($registration->status === 'cancelled' ? 'ion-close-circled' : ''))) }}" aria-hidden="true"></i> --}}
                        {{ __($registration->status) }}
                        </td>
                    @endif
                    <td>{{ $registration->created_at->format('d-m-Y / H:i' ) }}</td>
                    <td>{{ $registration->user->full_name }}</td>
                    <td>{{ $registration->user->company }}</td>
                    <td>{{ $registration->user->position }}</td>
                    <td>{{ $registration->user->email }}</td>
                    <td>{{ $registration->user->phone }}</td>
                    <td>{{ $registration->promo }}</td>
                     @if(!$showProduct)
                        <td>
                        <a href="#0" data-toggle="modal" data-target="#actionsModal{{ $index }}"><i class="ion ion-gear-a" aria-hidden="true"></i>&ensp;acciones</a>
                            <x-modal :id="'actionsModal' . $index" :title="'Acciones sobre la inscripción'" :footer="''">
                                @if($registration->status !== 'paid' && $registration->status !== 'accepted' && $registration->status !== 'pending')
                                    <div class="row">
                                        <div class="col">
                                            <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST" onsubmit="return confirm('Seguro que quieres aceptar la inscripción?');">
                                                <input type="hidden" name="action" value="accept">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block">Confirmar solicitud</button>
                                            </form>
                                        </div>
                                        @if($registration->status === 'new')
                                            <div class="col text-right">
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST" onsubmit="return confirm('Seguro que quieres invitar al usuario?');">
                                                    <input type="hidden" name="action" value="invite">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-block">Invitar<br>Asistente</button>
                                                </form>
                                            </div>
                                            <div class="col text-right">
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST" onsubmit="return confirm('Seguro que quieres denegar la inscripción?');">
                                                    <input type="hidden" name="action" value="deny">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-block">Denegar solicitud</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if($registration->status === 'paid' || $registration->status === 'pending' || $registration->status === 'accepted')
                                    <div class="row">
                                        <div class="col">
                                            @if($registration->status === 'pending')
                                                <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST" onsubmit="return confirm('Seguro que quieres confirmar el pago?');">
                                                    <input type="hidden" name="action" value="pay">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirmar pago</button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="col text-right">
                                            <form action="{{ route('registrations.update-status', ['registration' => $registration]) }}" method="POST" onsubmit="return confirm('Seguro que quieres cancelar la compra?');">
                                                <input type="hidden" name="action" value="cancel">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Cancelar compra</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </x-modal>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
