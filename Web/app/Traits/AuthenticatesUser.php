<?php

namespace Admin\Traits;

use Admin\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

trait AuthenticatesUser
{
    use AuthenticatesUsers;
    protected function sendFailedLoginResponse(Request $request) {
        if (! AdminUser::where ( 'email', $request->email )->first ()) {
            return redirect ()->back ()->withInput ( $request->only ( $this->username (), 'remember' ) )->withErrors ( [ 
                    $this->username () => Lang::get ( 'general.email_error' ) 
            ] );
        }

        if (! AdminUser::where ( 'email', $request->email )->where ( 'is_active', 1 )->first ()) {
            return redirect ()->back ()->withInput ( $request->only ( $this->username (), 'remember' ) )->withErrors ( [ 
                    'password' => Lang::get ( 'general.admin_active_error' ) 
            ] );
        }
        if (! AdminUser::where ( 'email', $request->email )->where ( 'password', bcrypt ( $request->password ) )->first ()) {
            return redirect ()->back ()->withInput ( $request->only ( $this->username (), 'remember' ) )->withErrors ( [ 
                    'password' => Lang::get ( 'general.password_error' ) 
            ] );
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $checkStatus = AdminUser::where ( 'email', $request->email )->first ();
        if($checkStatus != null && $checkStatus->is_active == 0){
            return $this->sendFailedLoginResponse($request);
        }


        $this->validateLogin($request);
        

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
           session()->put('userid',  $checkStatus->id);
           //Auth::guard('api')->loginUsingId($checkStatus->id);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        //$request->session()->regenerate();

        //$this->clearLoginAttempts($request);
        return redirect()->intended($this->redirectPath());
    }

}