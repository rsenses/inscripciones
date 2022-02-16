@extends('layouts.public')

@section('scripts_before')
<x-analytics :campaign="$campaign" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-sm-8 offset-sm-2">
            {!! $campaign->partner->privacy !!}
        </div>
    </div>
</div>
@endsection