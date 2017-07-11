<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Google2FAAuthenticator;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        //檢查是否啟用二階段驗證
        if ($this->guard()->once($this->credentials($request))) {
            /** @var User $user */
            $user = User::where($this->username(), $request->get($this->username()))->first();
            if ($user && $user->google2fa_secret) {
                //需進行二階段驗證
                session([
                    'user2fa'  => $user->id,
                    'remember' => $request->has('remember'),
                ]);

                return redirect()->route('login.2fa');
            }
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function login2FAForm()
    {
        $user = User::find(session('user2fa'));
        if (!$user || !$user->google2fa_secret) {
            return redirect()->route('login');
        }

        return view(config('google2fa.view'));
    }

    public function login2FA(Request $request)
    {
        $user = User::find(session('user2fa'));
        if (!$user || !$user->google2fa_secret) {
            return redirect()->route('login');
        }

        $valid = (new Google2FAAuthenticator($request, $user))->isAuthenticated();

        if (!$valid) {
            return back()->withErrors(['one_time_password' => '驗證碼無效']);
        }

        $this->guard()->login($user, session('remember'));

        session([
            'user2fa'  => null,
            'remember' => null,
        ]);

        return $this->sendLoginResponse($request);
    }
}
