Hola {{ $checkout->user->name }}
{{ Config::get('app.url') }}/checkouts/{{ $checkout->id }}?t={{ $checkout->token }}
