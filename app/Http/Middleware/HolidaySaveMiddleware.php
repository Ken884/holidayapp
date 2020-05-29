<?php

namespace App\Http\Middleware;

use Closure;

class HolidaySaveMiddleware
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
        $params = $request->all();

        return $next($request);
    }
}
