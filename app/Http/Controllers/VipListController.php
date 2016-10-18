<?php

namespace Flavorgod\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Models\Eloquent\User;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Models\Eloquent\VipList as VipListMember;


class VipListController extends Controller
{

    /**
     * The repository where the data is coming from
     *
     * @var Flavorgod\Models\Repository\ProductRepository $repo
     */
    protected $repo;

    /**
     * Create a new instance of VipListController
     */
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setViewName('homevip');
        $this->setTitleName('vip list');
        return view('viplist/vip');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->setValidator($request->all());

        if($validator->fails()){
            if($request->ajax()){
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->with('errors', $validator->errors())->withInput();
        }

        $this->subscribe($request);
         if($request->ajax()){
            return response()->json(['success' => 'You have been subscribed!'], 200);
        }
        alert()->success('You have been subscribed!')->autoclose(1500);
        return back();
    }

    /**
     * Determine which validator to use
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function setValidator($data)
    {
        if(array_key_exists('first_name', $data)){
            return $this->validator($data);
        }else{
            return $this->emailValidator($data);
        }
    }

    /**
     * Subscribe a new member to the vip List
     * @param Request $request
     */
    private function subscribe($request)
    {
        $user = User::byEmail($request->input('email'));

         if($user){
            $vip = new VipListMember($request->all());
            $user->vip()->save($vip);

        }else{
            VipListMember::create($request->all());
        }
    }

     /**
     * Get a validator for registering to the vip list
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:viplist',
            'first_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255'
        ], ['email.unique' => 'You already subscribed!']);
    }

    /**
     * Get a validator for registering to the vip list usin the form pop up
     *  on the index page
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function emailValidator($data)
    {
        return Validator::make($data, ['email' => 'required|email|max:255|unique:viplist'], ['email.unique' => 'You already subscribed!']);

    }
}
