<!-- Styles -->
@if((isset($checkout) && $checkout->campaign->partner->slug === 'telva') || $domain === 'telva')
<link href="{{ asset('css/telva.css') }}" rel="stylesheet">
<style>
    :root {
        --primary: #D70065;
    }
</style>
@elseif((isset($checkout) && $checkout->campaign->partner->slug === 'diariomedico') || $domain === 'diariomedico')
<link href="{{ asset('css/diariomedico.css') }}" rel="stylesheet">
<style>
    :root {
        --primary: #1172B8;
    }
</style>
@elseif((isset($checkout) && $checkout->campaign->partner->slug === 'marca') || $domain === 'marca')
<link href="{{ asset('css/marca.css') }}" rel="stylesheet">
<style>
    :root {
        --primary: #c00;
    }
</style>
@elseif((isset($checkout) && $checkout->campaign->partner->slug === 'expansion') || $domain === 'expansion')
<style>
    :root {
        --primary: #386AB0;
    }
</style>
@else
<style>
    :root {
        --primary: #2FC7DD;
    }
</style>
@endif

@if(isset($checkout))
@if($checkout->campaign->partner->slug === "marca")
<script src="https://tags.tiqcdn.com/utag/unidadeditorial/eventosue/prod/utag.sync.js">
</script>
@elseif($checkout->campaign->partner->slug === "diariomedico")
<script src="https://tags.tiqcdn.com/utag/unidadeditorial/profsanitarios/prod/utag.sync.js">
</script>
@else
<script src="https://tags.tiqcdn.com/utag/unidadeditorial/{{ $checkout->campaign->partner->slug }}/prod/utag.sync.js">
</script>
@endif
@endif
<script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/policy_v4.js"></script>
<script type="text/javascript">
    window.gdprAppliesGlobally = true; (function () {
        function a(e) {
            if (!window.frames[e]) {
                if (document.body && document.body.firstChild) { var t = document.body; var n = document.createElement("iframe"); n.style.display = "none"; n.name = e; n.title = e; t.insertBefore(n, t.firstChild) }
                else { setTimeout(function () { a(e) }, 5) }
            }
        } function e(n, r, o, c, s) {
            function e(e, t, n, a) { if (typeof n !== "function") { return } if (!window[r]) { window[r] = [] } var i = false; if (s) { i = s(e, t, n) } if (!i) { window[r].push({ command: e, parameter: t, callback: n, version: a }) } } e.stub = true; function t(a) {
                if (!window[n] || window[n].stub !== true) { return } if (!a.data) { return }
                var i = typeof a.data === "string"; var e; try { e = i ? JSON.parse(a.data) : a.data } catch (t) { return } if (e[o]) { var r = e[o]; window[n](r.command, r.parameter, function (e, t) { var n = {}; n[c] = { returnValue: e, success: t, callId: r.callId }; a.source.postMessage(i ? JSON.stringify(n) : n, "*") }, r.version) }
            }
            if (typeof window[n] !== "function") { window[n] = e; if (window.addEventListener) { window.addEventListener("message", t, false) } else { window.attachEvent("onmessage", t) } }
        } e("__tcfapi", "__tcfapiBuffer", "__tcfapiCall", "__tcfapiReturn"); a("__tcfapiLocator"); (function (e, tgt) {
            var t = document.createElement("script"); t.id = "spcloader"; t.type = "text/javascript"; t.async = true; t.src = "https://sdk.privacy-center.org/" + e + "/loader.js?target_type=notice&target=" + tgt; t.charset = "utf-8"; var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(t, n)
        })("178119d0-5586-4a4c-953e-04aaf9ac0994", "{{ isset($checkout) ? ($checkout->campaign->partner->cookies ?: 'DC8decYU') : 'DC8decYU' }}")
    })();
</script>