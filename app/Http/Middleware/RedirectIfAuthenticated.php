<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
                $role = Auth::user()->role->role_id;

                switch($role){
                    case 5:
                        return redirect('/admin/dashboard');
                    case 4:
                        return redirect('/accountant/transactions');
                    case 3:
                        return redirect('/doctor/dashboard');
                    case 2:
                        return redirect('/reception/time');
                    case 1:
                        return redirect('/doctor/dashboard');
                }
                
            }
        }

        return redirect('/login');
    }
}
