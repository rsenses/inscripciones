@section('scripts_before')
<x-analytics :campaign="$checkout->campaign" :checkout="[
    'payment_method_evento' => $checkout->method === 'card' ? 'tarjeta' : 'transferencia',
    'prod_name_evento' => transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', implode('|', $productNames)),
    'prod_quantity_evento' => implode('|', $productCounts),
    'prod_unitprice_evento' => implode('|', $productPrices),
    'prod_totalamount_evento' => $checkout->amount,
    'prod_promo_evento' => $checkout->deal ? 1 : 0,
]" />
@endsection