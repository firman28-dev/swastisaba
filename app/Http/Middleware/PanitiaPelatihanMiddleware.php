<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PanitiaPelatihanMiddleware
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
        $user = auth()->user();
        if ($user->id_group != 8) {
            return redirect()->route('unauthorized')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return $next($request);

        

    }
}
