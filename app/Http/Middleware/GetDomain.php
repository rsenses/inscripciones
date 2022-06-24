<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Partner;

class GetDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $host = str_replace('.localhost', '', request()->getHost());
        $hostNames = explode('.', $host);
        $domain = $hostNames[count($hostNames) - 2];

        View::share('domain', $domain);
        View::share('partner', Partner::where('slug', $domain)->first());

        return $next($request);
    }
}
