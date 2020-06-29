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

        $user = Auth::user();

        if (is_null($user->role))
            return redirect('login');

        if($user->role->role_id == 0) {
            return redirect('/admin/dashboard');
        } 

        if ($user->role->role_id == 1) {
            return redirect('/reception/time');
        } 

        if ($user->role->role_id == 2) {
            return redirect('/doctor');
        } 

        if ($user->role->role_id == 4) {
            return redirect('/accountant/transactions');
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
