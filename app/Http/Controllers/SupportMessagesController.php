<?php

namespace Flavorgod\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Flavorgod\Models\Eloquent\SupportMessage;
use Flavorgod\Http\Requests;
use Flavorgod\Http\Controllers\Controller;

class SupportMessagesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->messageValidator($request->all());

        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        $message = new SupportMessage;

        $message->fill($request->all());

        $message->save();

       alert()->success('We have received your enquiry.')->autoclose(2000);
        return back();

    }

    protected function messageValidator(array $data)
    {
        return Validator::make($data, [
            'enquiry_type' => 'required',
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'message' => 'required'
        ]);
    }

}
