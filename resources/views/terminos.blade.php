@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-sm-8 offset-sm-2">
            {!! $campaign->partner->conditions !!}
        </div>
    </div>
</div>
@endsection
