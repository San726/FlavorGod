<?php

namespace Flavorgod\Http\Controllers;

use Auth;
use File;
use Validator;
use Flysystem;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Models\Eloquent\User;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Validators\ProfileValidator;
use Flavorgod\Models\Repository\ProductRepository;

class ProfileController extends Controller
{
    /**
     * The repository where the data is coming from
     *
     * @var Flavorgod\Models\Repository\ProductRepository $repo
     */
    protected $repo;


    /**
     * Create a new members controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
        parent::__construct();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $currentUser = $this->user;
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        if($currentUser->payer_email){
            $request->session()->forget('confirmModal');
        }
        $currentUser->load(['addresses', 'storeCreditAccount', 'orders' => function($o){
            $o->take(4);
        }]);
        return view('members.profile', compact('currentUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $currentUser = $this->user;
        $this->setViewName('profileedit');
        $this->setTitleName('manage my account');
        return view('members.profileEdit', compact('currentUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileValidator $validator)
    {
        $params = $request->all();
        $validator = $validator->updateProfile($params);
        if($validator->fails()){
            return response()->json(['errors' => array_flatten($validator->errors()->toArray())], 422);
        }
        $currentUser = $this->user;
        unset($params['payer_email']);//We are not allowing then to change/update their email address for now
        $currentUser->fill($params);
        $currentUser->save();
        return response()->json(['success' => 'Profile updated']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'payer_email' => 'email|max:255|unique:customers',
            'address_state' => 'alpha|max:2'
        ],
        [
            'payer_email.email' => 'Please enter a valid email address.',
            'payer_email.max' => 'The email address is too long.',
            'payer_email.unique' => 'The email has already been taken.',
            'address_state.alpha' => 'Please enter valid state.',
            'address_state.max' => 'Please enter a two-letter state abbreviation.',
        ]);
    }

    /**
     * Update user's avatar image path and upload it to cloud
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileImageUpload(Request $request)
    {
        //get the file
        $file = $request->file('profileimage');
        $fileName = $this->fileName($file);

        $tmpDir = storage_path().'/tmp/';
        $tmpFile = $tmpDir.$fileName;
        //save file in local dir
        $file->move($tmpDir, $fileName);
        if(Flysystem::has('/assets/'.$fileName)){
            Flysystem::delete('/assets/'.$fileName);
        }
        //upload to s3
        $uploaded = Flysystem::write('/assets/'.$fileName, file_get_contents($tmpFile), ['visibility' => 'public']);
        if(!$uploaded){
             throw new Exception('Image could not be uploaded. Please try again later.');
        } else {
            //save new avatar path
            $this->user->avatar = 'https://s3.amazonaws.com/dash.flavorgod.com/assets/'.$fileName;
            $this->user->save();
        }
        //remove file from local
        File::delete($tmpFile);
        $user = $this->user->fresh();
        return response()->json(['success' => 'Image uploaded', 'image_path' => $user->avatar ]);
    }


    /**
     * Hash profile image file name
     * @param Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private function fileName($file)
    {
        $name = sha1($file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        return "{$name}.{$extension}";
    }
}
