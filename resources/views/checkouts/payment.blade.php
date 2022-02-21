@extends('layouts.public')

@section('scripts_before')
<x-analytics :campaign="$checkout->campaign" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2>Compra número: {{ $checkout->id }}<br>
                Importe {{ $checkout->amount }}€
            </h2>
            <div class="card bg-white">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Evento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkout->products->groupBy('id') as $product)
                                <tr>
                                    <td>{{ $product->count() }}</td>
                                    <td>{{ $product[0]->name }} <span class="text-uppercase">{{ $product[0]->mode }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if(!$discount)
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card bg-white">
                <div class="card-body">
                    <form method="POST" action="{{ route('deals.store', ['checkout_id' => $checkout->id]) }}" id="discount-data">
                        @csrf
                        <p>Si tienes un código de descuento, introdúcelo aquí</p>
                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                            <div class="col-md-8">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="code" autofocus>
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Usar código</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($message))
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card bg-white">
                <div class="card-body">
                    <p class="text-center">
                        <strong>CON TARJETA DE DÉBITO/CRÉDITO</strong>
                    </p>
                    <p><img src="{{asset('img/tarjetas.png')}}" class="img-fluid"></p>
                </div>
                <div class="card-footer">
                    {!! $form !!}
                </div>
            </div>
        </div>
        @if($checkout->amount > 100)
        <div class="col-lg-6">
            <div class="card bg-white">
                <div class="card-body">
                    <p class="text-center"><strong>CON TRANSFERENCIA desde tu banco:</strong></p>
                    <p>
                        <strong>Beneficiario</strong>: U.E.INFOR. ECONÓM. S.L.U<br>
                        <strong>Nombre del Banco</strong>: Bankinter<br>
                        <strong>Cuenta</strong>: 42 0128 6035 77 0100000587<br>
                        <strong>IBAN</strong>: ES 42 0128 6035 77 0100000587<br>
                        <strong>BIC</strong>: SWIFT BKBKESMMXXX<br>
                        <strong>Concepto de transferencia</strong>: Asistencia {{ $checkout->user->full_name }} {{ $checkout->id }}<br>
                    </p>
                </div>
                <div class="card-footer">
                    <a id="transfer_payment" href="{{ route('tpv.success', ['checkout' => $checkout, 'method' => 'transfer']) }}" class="btn btn-success btn-block btn-lg"> Pagar por transferencia</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    utag.link({
        "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
        "event_action": "{{ $checkout->campaign->short_name }}:datos facturacion" ,
        "be_onclick": "{{ $checkout->campaign->short_name }}:proceder al pago" ,
        "prod_name_evento": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)) }}",
        "prod_quantity_evento": "{{ implode('|', $productCounts) }}",
        "prod_unitprice_evento": "{{ implode('|', $productPrices) }}",
        "prod_totalamount_evento": "{{ $checkout->amount }}"
    });

    if (document.getElementById('redsys_form')) {
        document.getElementById('redsys_form').addEventListener("submit", function (e) {
            utag.link({
                "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
                "event_action": "{{ $checkout->campaign->short_name }}:datos bancarios" ,
                "be_onclick": "{{ $checkout->campaign->short_name }}:pago" ,
                "payment_method_evento" : "tarjeta",
                "prod_name_evento": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)) }}",
                "prod_quantity_evento": "{{ implode('|', $productCounts) }}",
                "prod_unitprice_evento": "{{ implode('|', $productPrices) }}",
                "prod_totalamount_evento": "{{ $checkout->amount }}"
                "prod_promo_evento": "{{ $discount ? 1 : 0 }}"
            });
        });
    }
    if (document.getElementById('transfer_payment')) {
        document.getElementById('transfer_payment').addEventListener("click", function (e) {
            utag.link({
                "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
                "event_action": "{{ $checkout->campaign->short_name }}:datos bancarios" ,
                "be_onclick": "{{ $checkout->campaign->short_name }}:pago" ,
                "payment_method_evento" : "transferencia",
                "prod_name_evento": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)) }}",
                "prod_quantity_evento": "{{ implode('|', $productCounts) }}",
                "prod_unitprice_evento": "{{ implode('|', $productPrices) }}",
                "prod_totalamount_evento": "{{ $checkout->amount }}"
                "prod_promo_evento": "{{ $discount ? 1 : 0 }}"
            });
        });
    }
</script>
@endsection