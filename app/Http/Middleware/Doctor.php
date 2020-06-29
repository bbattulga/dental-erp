<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Doctor
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
        if (Auth::check()){

            $role = Auth::user()->role->role_id;
            if ( ($role == 2)) {
                return $next($request);
            }
            return redirect('/test')->with(['data'=>'role not 2']);
        }
        return redirect('/test')->with(['data'=>'not auth']);
    }
}
