<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Roles;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated()
    {
        if (!Auth::check())
            return redirect('login');

        if (is_null(Auth::user()->role))
            return redirect('login');

        $role_id = Auth::user()->role->id;

        if($role_id == Roles::admin()->id) {
            return redirect('/admin/dashboard');
        } 

        if ($role_id == Roles::accountant()->id) {
            return redirect('/accountant/transactions');
        } 

        if ($role_id == Roles::doctor()->id) {
            return redirect('/doctor');
        } 

        if ($role_id == Roles::reception()->id) {
            return redirect('/reception/time');
        } 

        return redirect('login');
        
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
