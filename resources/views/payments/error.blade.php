@extends('layouts.public')

@section('scripts_before')
<x-analytics :campaign="$checkout->campaign" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2>{{ $checkout->campaign->name }}</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Asistente</strong></td>
                            <td>{{ $checkout->user->full_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Precio</strong></td>
                            <td>{{ $checkout->amount }}€</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger">
                Error al procesar el pago
            </div>
            <p class="text-center">
                <a href="{{ route('checkouts', ['checkout' => $checkout, 't' => $checkout->token]) }}" class="btn btn-primary">Reintentar</a>
            </p>
        </div>
    </div>
</div>
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