<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Roles;


class Reception
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

        if (!Auth::check())
            return redirect('login');

        $role = Auth::user()->role->role_id;

        if (($role==Roles::reception()->id) ||($role==Roles::admin()->id)) {
            return $next($request);
        }
        return redirect('login');
    }
}
