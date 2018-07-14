<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PemilikKost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 1)
            return response()->json([
                'message'   => 'Anda bukan pemilik kost',
            ]);
        return $next($request);
    }
}
