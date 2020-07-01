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
        $roles = $user->roles;

        if (is_null($roles))
            return redirect('login');

        if($this->check_role(5, $roles)) {
            return redirect('/admin/dashboard');
        } 

        if ($this->check_role(4, $roles)) {
            return redirect('/accountant/transactions');
        } 

        if ($this->check_role(3, $roles)) {
            return redirect('/doctor');
        } 

        if ($this->check_role(2, $roles)) {
            return redirect('/reception/user');
        } 

        if ($this->check_role(1, $roles)) {
            return redirect('/doctor');
        } 


        return redirect('login');
        
    }

    private function check_role($id, $roles){
        foreach($roles as $role){
            if ($role->role_id == $id)
                return true;
        }
        return false;
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
