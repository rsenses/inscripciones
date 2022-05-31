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
    document.getElementById('tax_type').addEventListener("change", function (e) {
        var state = document.getElementById('state');
        var country = document.getElementById('country');
        if (e.target.value == "Extranjero") {
            state.value = 'Extranjero';
            state.disabled = true;

            var input = document.createElement("input");

            input.setAttribute("type", "hidden");
            input.setAttribute("name", "state");
            input.setAttribute("value", "Extranjero");
            input.setAttribute("id", "h_state");
            //append to form element that you want .
            document.getElementById('invoice-data').appendChild(input);

            country.childNodes.forEach(function (element, index) {
                if (element.value === 'ES') {
                    element.classList.add('d-none');
                    element.disabled = true;
                }
            })
            country.value = 'FR';
        } else {
            state.value = '';
            state.disabled = false;

            country.childNodes.forEach(function (element, index) {
                if (element.value === 'ES') {
                    element.classList.remove('d-none');
                    element.disabled = false;
                }
            })
            country.value = 'ES';
        }
    });
    document.getElementById('invoice-data').addEventListener("input", function (e) {
        if (e.target.getAttribute("type") != "radio" && e.target.getAttribute('type') != 'checkbox') {
            var radios = document.getElementsByTagName('input');
            for (i = 0; i < radios.length; i++) {
                if (radios[i].getAttribute("type") == "radio") {
                    radios[i].checked = false;
                }
            }
        }
    });
</script>
@endsection