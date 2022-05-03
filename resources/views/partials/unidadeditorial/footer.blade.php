@guest
<footer class="mt-5 mb-5">
    <div class="container">
        <div class="row align-self-end">
            <div class="col-12 col-md-6 text-center text-md-left">
                &copy;{{ date('Y') }} Unidad Editorial S.A.
            </div>
            <div class="col-12 col-md-6">
                <ul class="list-inline text-center text-sm-right">
                    @if(isset($checkout))
                    <li class="list-inline-item">
                        <a class="text-xs-center" target="_blank" href="{{ route('terminos-y-condiciones', ['c' => $checkout->campaign]) }}">Términos y condiciones</a>
                    </li>
                    @endif
                    <li class="list-inline-item"><a class="text-xs-center" href="javascript:Didomi.preferences.show()">Politica de cookies</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
@endguest

@yield('scripts')