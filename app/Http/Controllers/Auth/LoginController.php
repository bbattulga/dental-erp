<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
        
        return redirect('/login');
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
