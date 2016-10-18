<?php

namespace Flavorgod\Http\Controllers\Auth\traits;

use Mail;
use Closure;
use Validator;
use MessageBag;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Flavorgod\Models\Eloquent\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Flavorgod\Services\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;

trait ResetsPasswords
{
    protected $redirectPath = 'members/profile';

    protected $emailView = 'emails.password';

    protected $subject = 'Your Password Reset Link';

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $validator = $this->passwordResetEmailValidator($request->all());
        if($validator->fails()){
            if($request->ajax()){
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $response = $this->sendResetLink($request);
        switch ($response) {
            case Password::RESET_LINK_SENT:
                if($request->ajax()){
                    return response()->json(['success' => 'Your password reset link has been sent.'], 200);                    
                }
                alert()->success('Your reset link has been sent.')->autoclose(1500);
                return redirect()->back();
            case Password::INVALID_USER:
                $message = new MessageBag;
                $message->add('errors', 'This user does not exists.');
                if($request->ajax()){
                    return response()->json($message, 422);                    
                }
                return redirect()->back()->withErrors($message);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your Password Reset Link';
    }

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendResetLink(Request $request)
    {
        $user = $this->getUser($request->all());
         if (is_null($user)) {
            return PasswordBrokerContract::INVALID_USER;
        }
        $token = $this->createToken($request->get('payer_email'));
        $user->remember_token = $token;
        $user->save();
        $fromDomain = $this->fromDomain($request->server('HTTP_REFERER'));
        if(!is_null($fromDomain)){
            $this->emailResetLink($user, $token, $fromDomain);
            return PasswordBrokerContract::RESET_LINK_SENT;            
        }
    }

    /**
     * Send the password reset link via e-mail.
     *
     * @param  \Flavorgod\Models\Eloquent\User  $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return int
     */
    public function emailResetLink($user, $token, $fromDomain)
    {
        $view = $this->emailView;
        return Mail::send($view, compact('token', 'user', 'fromDomain'), function($m) use ($user){
            $m->to($user->payer_email)->subject($this->getEmailSubject());
        });
    }


    /**
     * Get the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials)
    {
        return User::byEmail($credentials['payer_email']);
        
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        $user = User::byRememberToken($token);
        $email = $user->payer_email;
        $viewName = 'authreset';
        $this->setViewName('authreset');
        return view('auth.reset', compact('token', 'email'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('payer_email');
        $user = User::byEmail($email);

        Validator::extend('token_belongs_to_user', function() use ($token, $email, $user) {
            if($user && $user->remember_token == $token){
                return true;
            }else if($user && $user->remember_token != $token){
                return false;
            }else if(!$user){
                return true;
            }
        });

        $validator = $this->passwordResetTokenValidator($request->all());
        if($validator->fails()){
            if($request->ajax()){
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator->errors());
        }      

        $credentials = $request->only(
            'payer_email', 'password', 'password_confirmation', 'token'
        );
        $response = $this->resetPassword($credentials);
        switch ($response) {
            case Password::PASSWORD_RESET:
                alert()->success('Your password has been changed.')->autoclose(1500);
                return redirect($this->redirectPath());
            default:
                return redirect()->back()->withInput($request->only('payer_email'));
        }
    }

    /**
     * Reset the password for the given token.
     *
     * @param  array  $credentials
     * @return mixed
     */
    public function resetPassword(array $credentials)
    {
        $user = $this->getUser($credentials);
        $user->password = bcrypt($credentials['password']);
        $user->remember_token = $this->createToken($user->payer_email);
        $user->save();
        Auth::login($user);
        return PasswordBrokerContract::PASSWORD_RESET;
    }


    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}