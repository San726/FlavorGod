<?php

namespace Flavorgod\Http\Controllers\Auth\traits;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\CustomerAddress;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;

trait RegistersUsers
{
     /**
     * Get the for page to log the user in
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $this->setViewName('authregister');
        $this->setTitleName('new user sign up');
        return view('auth.register');
    }  

    /**
     * Handle a registration request for the application.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $params = $request->all();
        $validator = $this->registerValidator($params);
        if($validator->fails()){
            $errorBag = $validator->errors();
            $errors = $validator->errors()->toArray();
            //when email exists, has no password and all other validation passed
            if(count(array_keys($errors)) == 1 && array_key_exists('payer_email', $errors)){
                if(count($errors['payer_email']) == 1 && $errors['payer_email'][0] == 'The email exists but has not password.'){
                    return $this->doRegisterUser($params, $request);
                }
            }
            //check for any email errors
            if(array_key_exists('payer_email', $errors)){
                $flippedErrors = array_flip($errors['payer_email']);
                //handle when email exists with no password and have no more errors left
                if(array_key_exists('The email exists but has not password.', $flippedErrors)){
                    foreach ($errors['payer_email'] as $key => $errorMessage) {
                        if($errorMessage == 'The email exists but has not password.' || $errorMessage == 'The email has already been taken.'){
                            unset($errors['payer_email'][$key]);
                        }
                    }
                    if(count($errors) == 1 && empty($errors['payer_email'])){
                        return $this->doRegisterUser($params, $request);
                    }
                }
            }
            if(empty($errors['payer_email'])){
                unset($errors['payer_email']);
            }
            $newErrorBag = new MessageBag($errors);
            return response()->json($newErrorBag, 422);
        }
        return $this->doRegisterUser($params, $request);
    }

    private function doRegisterUser($params, $request)
    {
        DB::transaction(function() use ($params,  $request) {
        $user = Customer::where('payer_email', $params['payer_email'])->first();
            if(!$user){
                $user = Customer::create([
                    'payer_email' => $params['payer_email'],
                    'password' => bcrypt($params['password']),
                    'avatar' => '/images/cart-pro-img-2.jpg'
                ]);
            }else{
                $user->fill([
                    'password' => bcrypt($params['password']),
                    'avatar' => '/images/cart-pro-img-2.jpg'
                ]);
            }
            $verifySent = $this->sendEmailVerifyLink($user, $request->server('HTTP_REFERER'));
            if($verifySent){
                $user->verify_token = $verifySent;               
                $user->save();                                  
            }
            $this->onUserCreated($user);
        });
        return response()->json(['success' => 'Success! We need to verify your email. Please check your inbox and follow the verification steps.'], 200);
    }

    private function onUserCreated(Customer $user)
    {
        (new ReferralProgram)->setCustomer($user)->createAndAssignReferralDiscountCode();
        (new Manager)->createAndAssignStoreCreditAccountTo($user);        
    }
}