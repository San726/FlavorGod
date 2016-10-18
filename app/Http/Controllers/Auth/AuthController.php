<?php

namespace Flavorgod\Http\Controllers\Auth;

use Auth;
use Mail;
use Validator;
use Illuminate\Http\Request;
use Flavorgod\Models\Eloquent\User;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Services\ChannelAttribution;
use Flavorgod\Models\Eloquent\CustomerAddress;
use Flavorgod\Models\Repository\CartRepository;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Flavorgod\Http\Controllers\Auth\ManagesUsers;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Http\Controllers\Auth\traits\RegistersUsers;
use Flavorgod\Http\Controllers\Auth\traits\SocialAuthorizesUser;
use Flavorgod\Http\Controllers\Auth\traits\AuthenticatesUser;


class AuthController extends Controller
{

    use AuthenticatesUser, RegistersUsers, SocialAuthorizesUser, ManagesUsers;

    /**
     * The repository where the data is coming from
     *
     * @var Flavorgod\Models\Repository\ProductRepository $repo
     */
    protected $repo;
    protected $carts;
    protected $attrs;


    /**
     * Create a new instance of HomeController
     * @param Flavorgod\Models\Repository\ProductRepository $repo
     */
    public function __construct(ProductRepository $repo, CartRepository $carts, Request $request)
    {
        $this->middleware('guest', ['except' => ['getLogout', 'emailConfirm']]);
        $this->repo = $repo;
        parent::__construct();

        $this->carts = $carts;
        $this->attrs = new ChannelAttribution($request->server('HTTP_HOST'));

        $sid = Auth::check() ? Auth::user()->payer_email : $request->session()->getId();

        $this->carts
        ->setCustom($this->attrs->getCustom())
        ->setChannel($this->attrs->getChannel())
        ->setAgent($this->attrs->getAgent())
        ->setSessionId($sid);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registerValidator(array $data)
    {
        Validator::extend('email_exists', function($param, $value){
            $user = Customer::where($param, $value)->first();
            if($user){
                return false;
            }
            return true;
        });
        Validator::extend('email_and_password_exists', function($param, $value){
            $user = Customer::where($param, $value)->first();
            if($user){
                return $user->password == NULL ? false : true;
            }
            return true;
        });
        return Validator::make($data, [
            'payer_email' => 'required|email|max:255|email_exists|email_and_password_exists',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ], [
            'payer_email.email_exists' => 'The email has already been taken.',
            'payer_email.email_and_password_exists' => 'The email exists but has not password.'
        ]);
    }

    /**
     * Get a validator for an incoming login request
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
         Validator::extend('is_verified', function($param, $value){
            $user = User::byEmail($value);
            if($user && $user->verified){
                return true;
            }else if($user && !$user->verified){
                return false;
            }else if(!$user){
                return true;
            }
        });
         //Determine if user has not password to manage the verify email
         Validator::extend('has_no_password', function($param, $value){
            $user = User::byEmail($value);
            if($user && !$user->password){
                return false;
            }else{
                return true;
            }
         });

        return Validator::make($data, [
            'payer_email' => 'required|email|is_verified|has_no_password',
            'password' => 'required'
        ], [
            'payer_email.is_verified' => 'unverified',
            'payer_email.has_no_password' => 'has_no_password'
        ]);
    }

    /**
     * Get a validator for verifying the email
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function verifyEmailValidator(array $data)
    {
        return Validator::make($data, [
            'payer_email' => 'required|email|exists:customers',
            'verify_token' => 'required|exists:customers|token_belongs_to_user'
        ],[
            'verify_token.token_belongs_to_user' => 'The verification token is invalid.'
        ]);
    }

    /**
     * Send email verification link
     * @param Flavorgod\Models\Eloquent\User $user
     * @param string $token
     * @param string the name of the domain we want the user to be redirected to when they follow the link
     */
    protected function sendEmailVerifyLink($user, $fromDomain)
    {
        $fromDomain = $this->fromDomain($fromDomain);
        if(!is_null($fromDomain)){
            $view = 'emails.verify';
            $token = $this->createToken($user->payer_email);        
            Mail::send($view, compact('token', 'user', 'fromDomain'), function($m) use ($user){
                $m->to($user->payer_email)->subject('Please verify your email.');
            });           
            return $token;
        }        
    }

    /**
     * Display the email verification view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getVerifyEmail($token = null)
    {
        Auth::logout();
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        if(!$user = User::byVerifyToken($token)){
            return redirect('/');
        }
        $user->fill([
            'auth_type' => 'auth',
            'verified' => 1,
            'verify_token' => $this->createToken($user->payer_email)
        ]);
        $user->save();
        Auth::login($user);
        return redirect('/members/profile');      
    }

    /**
     * confirm the users's identity by checking the verify_token belongs
     * to user
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function postVerifyEmail(Request $request)
    {   
        $token = $request->input('verify_token');
        $email = $request->input('payer_email');
        $user = User::byEmail($email);
        //Handle the users that have been verified and try to verify again.
        if($user->verified){
            alert()->info('Account already verified.')->autoclose(2000);
            return redirect('/');
        }        
        Validator::extend('token_belongs_to_user', function() use ($token, $email, $user) {
            if($user && $user->verify_token == $token){
                return true;
            }else if($user && $user->verify_token != $token){
                return false;
            }else if(!$user){
                return true;
            }
        });
        $validator = $this->verifyEmailValidator(['verify_token' => $token, 'payer_email' => $email]);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $user->verified = 1;
        $user->auth_type = 'auth';
        $user->save();
        Auth::login($user);
        $this->carts->patch($this->fillCartDetails(Auth::user()));
        $this->carts->takeOver(Auth::user()->payer_email);
        $cart = $this->carts->fetch();
        alert()->success('Email confirmed!')->autoclose(2000);
        if(count($cart['items'])){
            return redirect()->route('cart_view_contact');
        }
        return redirect()->action('MembersController@show'); 
    }

    /**
     * Resend verification email to a user who received the email before
     * @param string $email 
     */
    public function resendVerifyEmail($email, Request $request)
    {
        $domain = $request->server('HTTP_REFERER');
        $user = User::byEmail($email);
        if($user && !$user->verified){
            $verifySent = $this->sendEmailVerifyLink($user, $domain);
            if($verifySent){
                $user->fill(['verify_token' => $verifySent]);
                $user->save();
            }
            alert()->success('Email verification was sent!')->autoclose(2000);
            return redirect('/');
        }
    }

    /**
     * Fill in the cart details with the current user auth data
     * @param Flavorfog\Models\User $user
     */
    protected function fillCartDetails($user){

        $billing = CustomerAddress::getBilling($user);
        $shipping = CustomerAddress::getShipping($user);
        $details = [
            'contact_firstname' => $user->first_name,
            'contact_lastname' => $user->last_name,
            'contact_phone' => $user->contact_phone,
            'contact_email' => $user->payer_email,
            'billing_firstname' => $user->first_name,
            'billing_lastname' => $user->last_name,
            'billing_address' => ($billing ? $billing->address_street : $user->address_street),
            'billing_address2' => ($billing ? $billing->address_street2 : NULL),
            'billing_city' => ($billing ? $billing->address_city : $user->address_city),
            'billing_state' => ($billing ? $billing->address_state : $user->address_state),
            'billing_zip' => ($billing ? $billing->address_zip : $user->address_zip),
            'billing_country' => ($billing ? $billing->address_country_code : $user->address_country_code),
            'shipping_firstname'=> $user->first_name,
            'shipping_lastname' => $user->last_name,
            'shipping_address' => ($shipping ? $shipping->address_street : $user->address_street),
            'shipping_address2' => ($shipping ? $shipping->address_street2 : NULL),
            'shipping_city' => ($shipping ? $shipping->address_city : $user->address_city),
            'shipping_state' => ($shipping ? $shipping->address_state : $user->address_state),
            'shipping_zip' => ($shipping ? $shipping->address_zip : $user->address_zip),
            'shipping_country' => ($shipping ? $shipping->address_country_code : $user->address_country_code) 
         ];
         return $details;
    }
}
