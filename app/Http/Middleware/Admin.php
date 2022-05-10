<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'financial' && auth()->user()->role !== 'superadmin') {
            auth()->logout();

            return redirect()->route('login');
        }

        return $response;
    }
}
