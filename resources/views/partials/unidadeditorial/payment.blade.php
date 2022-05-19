@section('scripts_before')
<x-analytics :campaign="$checkout->campaign" :checkout="[
    'payment_method_evento' => $checkout->method === 'card' ? 'tarjeta' : 'transferencia',
    'prod_name_evento' => transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)),
    'prod_quantity_evento' => implode('|', $productCounts),
    'prod_unitprice_evento' => implode('|', $productPrices),
    'prod_totalamount_evento' => $checkout->amount,
    'prod_promo_evento' => $checkout->deals ? 1 : 0,
]" />
@endsection

@section('scripts')
<script>
    window.onload = function() {
        utag.link({
            "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
            "event_action": "{{ $checkout->campaign->short_name }}:datos facturacion" ,
            "be_onclick": "{{ $checkout->campaign->short_name }}:proceder al pago" ,
            "prod_name_evento": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)) }}",
            "prod_quantity_evento": "{{ implode('|', $productCounts) }}",
            "prod_unitprice_evento": "{{ implode('|', $productPrices) }}",
            "prod_totalamount_evento": "{{ $checkout->amount }}"
        });
    };

    if (document.getElementById('discount_data')) {
        document.getElementById('discount_data').addEventListener("submit", function (e) {
            utag.link({
                "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
                "event_action": "{{ $checkout->campaign->short_name }}:codigo promocional" ,
                "be_onclick": "{{ $checkout->campaign->short_name }}:usar codigo" ,
                "prod_name_evento": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)) }}",
                "prod_quantity_evento": "{{ implode('|', $productCounts) }}",
                "prod_unitprice_evento": "{{ implode('|', $productPrices) }}",
                "prod_totalamount_evento": "{{ $checkout->amount }}"
            });
        });
    }
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
                "prod_totalamount_evento": "{{ $checkout->amount }}",
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
                "prod_totalamount_evento": "{{ $checkout->amount }}",
                "prod_promo_evento": "{{ $discount ? 1 : 0 }}"
            });
        });
    }
</script>
@endsection