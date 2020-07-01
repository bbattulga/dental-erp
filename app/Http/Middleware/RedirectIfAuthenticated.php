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
            return redirect('/test')->with(['data'=>'guard passed']);
            if (is_null(Auth::user()->roles)){
                return redirect('/register');
            } else {
                $roles = Auth::user()->roles;

                if(check_role(5, $roles) ){
                  //  return redirect('/test', ['data'=>'admin']);
                    return redirect('/admin/dashboard');
                } 
                elseif (check_role(4, $roles)) {
                    return redirect('/accountant/transactions');
                }
                elseif (check_role(3, $roles)) {
                    return redirect('/doctor/dashboard');
                } 
                elseif (check_role(2, $roles)) {
                    return redirect('/reception/time');
                }
                 else {
                    return redirect('/user');
                }
            }
        }

        return redirect('/test')->with(['data'=>'no role match']);
    }

    private function check_role($id, $roles){
        foreach($roles as $role){
            if ($role->role_id == $id)
                return true;
        }
        return false;
    }
}
