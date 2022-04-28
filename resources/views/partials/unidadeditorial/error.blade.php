@section('scripts_before')
<x-analytics :campaign="$checkout->campaign" />
@endsection

@section('scripts')
<script>
    utag.link({
        "event_category": "{{ transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $checkout->campaign->name) }}",
        "event_action": "{{ $checkout->campaign->short_name }}:error pago",
        "event_label" : "{{ $checkout->campaign->short_name }}:{{ $checkout->tpv }}",
    });
</script>
@endsection