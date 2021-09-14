@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-sm-8 offset-sm-2">
            {!! $checkout->product->partners[0]->conditions !!}
        </div>
    </div>
</div>
@endsection
