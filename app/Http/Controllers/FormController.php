<?php

namespace Flavorgod\Http\Controllers;

use Mail;
use Cache;
use Instagram;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Accounts\Providers\Contracts\Provider;
use Flavorgod\Services\ChannelAttribution;
use Validator;
use Carbon\Carbon;

class FormController extends Controller
{

    /**
     * Display the vipreview page
     *
     * @return \Illuminate\Http\Response
     */
    public function vipreview()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('vip list');

        return view('forms.vipreview');
    }

    /**
     * Display the vipreview page
     *
     * @return \Illuminate\Http\Response
     */
    public function postVipreview(Request $request)
    {
        $input = $request->all();
        $email_to = 'vipreview@flavorgod.com';
        $form_name = 'vipreview';

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_phone' => 'required',
            'address_line1' => 'required',
            'address_city' => 'required',
            'address_zipcode' => 'required',
            'address_state' => 'required',
            'address_country' => 'required',
            'g-recaptcha-response' => 'required',
        ],
        array('g-recaptcha-response.required' => 'Please check the recaptcha if you\'re not a robot'));

        $secretKey = config('recaptcha.secret');
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$input['g-recaptcha-response']."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);

        if ($validator->fails()) {
            return redirect('vipreview#form_error')
                        ->withErrors($validator)
                        ->withInput();
        }
        // check if it's not a spammer
        elseif(intval($responseKeys["success"]) === 1){

            unset($input['_token']);

            Mail::send('forms.email-template', compact('input'), function($m) use ($email_to){
                $m->to($email_to)->subject('Flavorgod - Vipreview Form Data');
            });

            \DB::table('form_inputs')->insert(array(
                'form_name'=>$form_name, 
                'email_to'=>$email_to, 
                'json_response' => json_encode($input),
                'created_at' => Carbon::now()
                )
            );
            return redirect('vipreview/submitted');
        }

    }

    /**
     * Display the vipreview page 2
     *
     * @return \Illuminate\Http\Response
     */
    public function vipreviewThankyou()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('vip list');
        return view('forms.vipreview-thankyou');
    }

    /**
     * Display the wholesale page
     *
     * @return \Illuminate\Http\Response
     */
    public function wholesale()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('wholesale');

        return view('forms.wholesale');
    }

    /**
     * Display the wholesale page
     *
     * @return \Illuminate\Http\Response
     */
    public function postWholesale(Request $request)
    {
        $input = $request->all();
        $email_to = 'wholesale@flavorgod.com';
        $form_name = 'wholesale';

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_phone' => 'required',
            'address_line1' => 'required',
            'address_city' => 'required',
            'address_zipcode' => 'required',
            'address_state' => 'required',
            'g-recaptcha-response' => 'required',
        ],
        array('g-recaptcha-response.required' => 'Please check the recaptcha if you\'re not a robot'));

        $secretKey = config('recaptcha.secret');
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$input['g-recaptcha-response']."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);

        if ($validator->fails()) {
            return redirect('wholesale#form_error')
                        ->withErrors($validator)
                        ->withInput();
        }
        // check if it's not a spammer
        elseif(intval($responseKeys["success"]) === 1){

            unset($input['_token']);

            Mail::send('forms.email-template', compact('input'), function($m) use ($email_to){
                $m->to($email_to)->subject('Flavorgod - Wholesale Form Data');
            });

            \DB::table('form_inputs')->insert(array(
                'form_name'=>$form_name, 
                'email_to'=>$email_to, 
                'json_response' => json_encode($input),
                'created_at' => Carbon::now()
                )
            );
            return redirect('wholesale/submitted');
        }

    }

    /**
     * Display the wholesale page 2
     *
     * @return \Illuminate\Http\Response
     */
    public function wholesaleThankyou()
    {
        $this->setViewName('homeabout');
        $this->setTitleName('Wholesale');
        return view('forms.wholesale-thankyou');
    }

}