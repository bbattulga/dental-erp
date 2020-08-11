<?php

namespace App\Http\Middleware;

use Closure;

class RegisterMiddleware
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
        if (strcmp($request['code'], '6575013') == 0)
            return $next($request);
        return redirect('/register');
    }
}
