<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Roles;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            if (is_null(Auth::user()->role)){
                return redirect('/user');
            } else {

                if(Auth::user()->role->role_id == Roles::admin()->id) {
                    return redirect('/admin/dashboard');
                } 

                if (Auth::user()->role->role_id == Roles::accountant()->id) {
                    return redirect('/accountant/transactions');
                }

                if (Auth::user()->role->role_id == Roles::doctor()->id) {
                    return redirect('/doctor/dashboard');
                }

                if (Auth::user()->role->role_id == Roles::reception()->id) {
                    return redirect('/reception/time');
                }
                return redirect('/user');
            }
        }

        return $next($request);
    }
}
