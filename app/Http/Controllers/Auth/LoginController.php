<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**r
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
       // Jika mobile / web mengirim fcm_token → simpan
        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
        } 
        
        // Jika user tidak punya fcm_token → generate
        if (is_null($user->fcm_token) || $user->fcm_token === '') {
            $user->fcm_token = Str::uuid()->toString(); // lebih aman daripada random string
        }

        $user->save();
    }

    public function username()
    {
        return 'nik';
    }
}
