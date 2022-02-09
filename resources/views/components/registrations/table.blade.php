<div class="table-responsive">
    @if(!$showProduct)
    <div class="toolbar">
        <a href="#0" class="btn btn-danger" data-toggle="modal" data-target="#claim">Reclamar no pagados</a>
    </div>
    <x-modal :id="'claim'" :title="'Reclamar pendientes de pago'" :footer="''">
        <p>¿Seguro que quieres mandar un email para reclamar el pago a TODOS los pendientes?</p>
        <p class="text-danger"><strong>Recuerda completar las invitaciones antes de usar esta función.</strong></p>
        <p><a href="{{ route('emails.claim', ['product' => $registrations[0]->product]) }}"
                class="btn btn-success">Enviar reclamacion de pago</a></p>
    </x-modal>
    @endif
    <table class="table " {{ $showProduct ? '' : 'data-toggle=table' }} data-search="true"
        data-show-export="true" data-export-data-type="basic" data-export-types="['csv']" data-locale="es_ES"
        data-filter-control="true" data-toolbar=".toolbar">
        <thead>
            <tr>
                @if($showProduct)
                <th data-field="product" data-sortable="true">Producto</th>
                @else
                <th data-field="status" data-sortable="true" data-filter-control="select">Status</th>
                @endif
                <th data-field="paid_at" data-sortable="true">Fecha Insc./Pago</th>
                <th data-field="amount" data-sortable="true">Precio</th>
                <th data-field="full_name" data-sortable="true">Nombre</th>
                <th data-field="company" data-sortable="true">Empresa</th>
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
                    {{ $registration->product->name }} <span class="badge badge-info">{{ $registration->product->mode
                        }}</span>
                </td>
                @else
                <td
                    class="alert {{ $registration->status === 'accepted' ? 'alert-info' : ($registration->status === 'paid' ? 'alert-success' : ($registration->status === 'denied' ? 'alert-danger' : ($registration->status === 'cancelled' ? 'alert-warning' : ($registration->status === 'pending' ? 'alert-info' : '')))) }}">
                    {{-- <i
                        class="ion {{ $registration->status === 'accepted' ? 'ion-thumbsup' : ($registration->status === 'paid' ? 'ion-cash' : ($registration->status === 'denied' ? 'ion-thumbsdown' : ($registration->status === 'cancelled' ? 'ion-close-circled' : ''))) }}"
                        aria-hidden="true"></i> --}}
                    {{ __($registration->status) }}
                </td>
                @endif
                <td>{{ !empty($registration->checkout->paid_at) ? $registration->checkout->paid_at->format('d-m-Y
                    H:i' ) : $registration->created_at->format('d-m-Y
                    H:i' ) }}</td>
                <td>{{ !empty($registration->checkout->amount) ? $registration->checkout->amount . '€' : '' }}</td>
                <td>{{ $registration->user->full_name }}</td>
                <td>{{ $registration->user->company }} <small>{{ $registration->user->position }}</small></td>
                <td>{{ $registration->user->email }}</td>
                <td>{{ $registration->user->phone }}</td>
                <td>{{ $registration->promo }}</td>
                @if(!$showProduct)
                <td>
                    <a href="#0" data-toggle="modal" data-target="#actionsModal{{ $index }}"><i class="ion ion-gear-a"
                            aria-hidden="true"></i>&ensp;acciones</a>
                    <x-modal :id="'actionsModal' . $index" :title="'Acciones sobre la inscripción'" :footer="''">
                        <div class="row mb-3">
                            <div class="col">
                                <a href="{{ route('registrations.resend-email', ['registration' => $registration]) }}"
                                    class="btn btn-secondary btn-block"
                                    onsubmit="return confirm('Seguro que quieres reenviar el email?');">
                                    Reenviar email
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            @if($registration->status !== 'paid' && $registration->status !== 'accepted' &&
                            $registration->status !== 'pending')
                            <div class="col">
                                <form
                                    action="{{ route('registrations.update-status', ['registration' => $registration]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Seguro que quieres aceptar la inscripción?');">
                                    <input type="hidden" name="action" value="accept">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block">Confirmar solicitud</button>
                                </form>
                            </div>
                            @endif
                            @if($registration->status === 'new' || $registration->status === 'accepted')
                            <div class="col text-right">
                                <form
                                    action="{{ route('registrations.update-status', ['registration' => $registration]) }}"
                                    method="POST" onsubmit="return confirm('Seguro que quieres invitar al usuario?');">
                                    <input type="hidden" name="action" value="invite">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-warning btn-block">Invitar<br>Asistente</button>
                                </form>
                            </div>
                            @endif
                            @if($registration->status === 'new')
                            <div class="col text-right">
                                <form
                                    action="{{ route('registrations.update-status', ['registration' => $registration]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Seguro que quieres denegar la inscripción?');">
                                    <input type="hidden" name="action" value="deny">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block">Denegar solicitud</button>
                                </form>
                            </div>
                            @endif
                            @if($registration->status === 'paid' || $registration->status === 'pending' ||
                            $registration->status === 'accepted')
                            <div class="col">
                                @if($registration->status === 'pending')
                                <form
                                    action="{{ route('registrations.update-status', ['registration' => $registration]) }}"
                                    method="POST" onsubmit="return confirm('Seguro que quieres confirmar el pago?');">
                                    <input type="hidden" name="action" value="pay">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirmar pago</button>
                                </form>
                                @endif
                            </div>
                            <div class="col text-right">
                                <form
                                    action="{{ route('registrations.update-status', ['registration' => $registration]) }}"
                                    method="POST" onsubmit="return confirm('Seguro que quieres cancelar la compra?');">
                                    <input type="hidden" name="action" value="cancel">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancelar compra</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </x-modal>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
