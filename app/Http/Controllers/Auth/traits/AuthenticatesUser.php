<?php

namespace Flavorgod\Http\Controllers\Auth\traits;

use Crypt;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Collection;


trait AuthenticatesUser
{   
    /**
     * Handle redirecting users who authenticated via social auth
     * @param string $code || null
     */
    public function socialRedirect($code)
    {
        if(!is_null($code)){
            $identity = Crypt::decrypt($code);            
            if(array_key_exists('unverified', $identity)){
                $errors = new MessageBag;
                $errors->add('errors', 'unverified');                
                return redirect($identity['referer'].'/auth/login')->withErrors($errors)->withEmail($identity['user']);
            }
            if(!empty($identity['user'])){
                $user = User::where('payer_email', $identity['user'])->first();
                Auth::login($user);
                $this->carts->patch($this->fillCartDetails(Auth::user()));
                $this->carts->takeOver(Auth::user()->payer_email);
                $cart = $this->carts->fetch();
                if(count($cart['items'])){
                    return redirect($identity['referer'].'/cart/contact');
                }
                return redirect($identity['referer'].'/members/profile');      
            }
        }else{
            return redirect()->away($identity['referer']);
        }
    }


    /**
     * Get the for page to log the user in
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin($code = null)
    {   
        $this->setViewName('authlogin');
        $this->setTitleName('user login');
        return view('auth.login');        
    }

	/**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $validator = $this->loginValidator($request->all());
        if($validator->fails()){
            if($request->ajax()){//Respond only to ajax requests                
                $flippedErrors = array_flip($validator->errors()->toArray()['payer_email']);
                $withNoPasswordMessage = 'has_no_password';
                if(array_key_exists($withNoPasswordMessage, $flippedErrors)){
                    $newErrorBag = new MessageBag(['payer_email' => [$withNoPasswordMessage]]);
                    return response()->json($newErrorBag, 422);                   
                }               
                return response()->json($validator->errors(), 422);
            }
        }
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        if($authenticated = $this->authenticateTheUser($this->getCredentials($request))){
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        if($request->ajax()){
          return response()->json(['errors' => 'These credentials do not match our records.'], 422);
        }
        return back()->withErrors(['These credentials do not match our records'])->withInput();
    }

    public function authenticateTheUser($credentials)
    {
        if (Auth::attempt($credentials)){
            $this->carts->patch($this->fillCartDetails(Auth::user()));
            $this->carts->takeOver(Auth::user()->payer_email);
            return true;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
     {
        $user = Auth::user();
        $user->auth_type = 'auth';
        $user->save();

        if ($throttles) {
            $this->clearLoginAttempts($request);
        }
        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request);
        }
        if($request->ajax()){
            if(empty($request->get('cartId'))){
                return response()->json(['success' => 'You have been succesfully logged in'], 200); 
            }else{
                return response()->json(['successWithCart' => 'You have been succesfully logged in'], 200);   
            }
        }
        return redirect()->action('MembersController@show');
    }

    /**
     * Respond after the user has been authenticated
     * @param Request $request
     * @param User $user
     */
    protected function authenticated($request)
    {      
        if($request->ajax()){
            if(empty($request->get('cartId'))){
                return response()->json(['success' => 'You have been succesfully logged in'], 200);
            }else{
                return response()->json(['successWithCart' => 'You have been succesfully logged in'], 200);
            }
        }
        return redirect()->action('MembersController@show');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout(Request $request)
    {
        //handle/ update cart data
        $this->carts->patch($this->fillCartDetails(Auth::user()));
        $sid = $request->session()->getId();
        $this->carts->takeOver($sid);
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'payer_email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }


}