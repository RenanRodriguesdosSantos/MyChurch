<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Obreiro
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
        if($request->user()->type == 3){
            return abort(403);
        }
        return $next($request);
    }
}
