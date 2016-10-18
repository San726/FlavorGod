<?php

namespace Flavorgod\Http\Controllers\Auth\traits;

use DB;
use Crypt;
use SocialAuth;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\User;
use Illuminate\Support\Facades\Auth;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;
use SocialNorm\Exceptions\ApplicationRejectedException;
use SocialNorm\Exceptions\InvalidAuthorizationCodeException;

trait SocialAuthorizesUser
{

	/**
	 * The user returned after social api auth
	 * @var string
	 */
	protected $userFromSocial;


	/**
     * Redirect the user to the social network authorization page
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function socialAuthorize($provider, $code, Request $request)
    {
        $referer = $this->fromDomain($request->server('HTTP_REFERER'));
        if(!is_null($referer)){
            $identity = Crypt::decrypt($code);
            $orig_identity = [
                'user' => null,
                'session_id' => $identity,
                'origin' => $request->server('HTTP_HOST'),
                'referer' => $referer
            ];
            $request->session()->flash('orig_identity', $orig_identity);
            return SocialAuth::authorize($provider);
        }
    }

     /**
     * Obtain users information from social network
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function socialLogin($provider, Request $request)
    {
        try{
            SocialAuth::login($provider, function($user, $details){
                $fullName = explode(" ", $details->full_name);
                $user->fill([
                    'first_name' => (array_key_exists(0, $fullName) ? $fullName[0] : ""),
                    'last_name' => (array_key_exists(1, $fullName) ? $fullName[1] : ""),
                    'payer_email' => $details->email,
                    'oauth_avatar' => $details->avatar,
                    'auth_type' => 'oauth2'
                 ]);
                $user->save();             
                (new ReferralProgram)->setCustomer($user)->createAndAssignReferralDiscountCode();
                (new Manager)->createAndAssignStoreCreditAccountTo($user); 
            });
        } catch (ApplicationRejectedException $e) {
                // User rejected application
                return redirect('/');
        } catch (InvalidAuthorizationCodeException $e) {
                // Authorization was attempted with invalid
                // code,likely forgery attempt
                return redirect('/');
        }
        $this->userFromSocial = Auth::user();
        $users = User::where('payer_email', $this->userFromSocial->payer_email)->get();
        //this is for new social auths
        if($users->count() > 1){
            $this->handlemoreThanOne($users);
        }
        $user = Auth::user();
        $identity = session('orig_identity');
        $identity['user'] = $user->payer_email;
        //Handle users if they have not verified their account
        if(!$user->verified && $user->password != NULL){
            $identity['unverified'] = true;
            //send verification token if we havent already
            if(!$user->verify_token){
                $verifySent = $this->sendEmailVerifyLink($user, $identity['referer']);
                if($verifySent){
                    $user->fill(['verify_token' => $verifySent]);
                    $user->save();
                }
            }
            //handle users that are not verified and come from flavorgod.com the main site
            if($identity['referer'] == $this->mainReferer){
                $this->carts->patch($this->fillCartDetails(Auth::user()));
                $sid = $request->session()->getId();
                $this->carts->takeOver($sid);
                $email = Auth::user()->payer_email;
                Auth::logout();
                $errors = new MessageBag;
                $errors->add('errors', 'unverified');
                return redirect()->away($this->mainReferer.'/auth/login')->withErrors($errors)->withEmail($email);
            }
        }
        //Handle users when they login from flavorgod.com the main site
        if($identity['referer'] == $this->mainReferer)
        {
            //handle/update cart data
            $this->carts->patch($this->fillCartDetails(Auth::user()));
            $this->carts->takeOver(Auth::user()->payer_email);
            $cart = $this->carts->fetch();
            if(count($cart['items'])){
                return redirect()->away($this->mainReferer.'/cart/contact');
            }
            return redirect()->away($this->mainReferer. '/members/profile');
        }
        //Handle users when they login from using a subdomain
        Auth::logout();
        return redirect()->away($identity['referer'] . '/auth/socialredirect/' . Crypt::encrypt($identity));
      }

    /**
     * Update the original user which does not have an oath identity stored in our system  and update this user's data
     * with the new data from the user generated by the social api. Once we do that log authenticate the original user
     * This will happen only when we have a user generated the regular way first and that same user tries to login user
     * using his/her social credentials
     *
     * @param Illuminate\Support\Collection $users
     */
    private function handlemoreThanOne($users)
    {
        $originalUser = $users->sortBy('id')->first();
        $originalUser->fill($this->userFromSocial->getAttributes());
        $originalUser->save();
        DB::table('oauth_identities')->where('user_id', $this->userFromSocial->id)->update(['user_id' => $originalUser->id]);
        User::destroy($this->userFromSocial->id);
        return Auth::login($originalUser);
    }
}