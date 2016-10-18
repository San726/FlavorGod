<?php

namespace Flavorgod\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Flavorgod\Http\Requests;
use Flavorgod\Models\Eloquent\User;
use Flavorgod\Models\Eloquent\Country;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Models\Eloquent\CustomerAddress;
use Flavorgod\Models\Repository\ProductRepository;
use Flavorgod\Validators\CustomerAddressValidator;

class AddressController extends Controller
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
     * Display Addresses to select default billing
     */
    public function billingIndex()
    {
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        $this->user->load('addresses');
        $this->user->addresses = $this->user->addresses->sortByDesc('is_billing');
        $currentUser = $this->user;
        return view('members.billingaddress', compact('currentUser'));
    }

    /**
     * Display Addresses to select default billing
     */
    public function shippingIndex()
    {
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        $this->user->load('addresses');
        $this->user->addresses = $this->user->addresses->sortByDesc('is_shipping');
        $currentUser = $this->user;
        return view('members.shippingaddress', compact('currentUser'));
    }

    /**
     * Display an address to edit
     */
    public function edit($id)
    {
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        $this->user->load('addresses');
        $currentAddress = $this->user->addresses->filter(function($a) use ($id) {
            return $a->id == $id;
        });
        if($currentAddress->count()){
            $countries = $this->listCountries();
            $currentUser = $this->user;
            $currentAddress = $currentAddress->first();
            return view('members.editaddress', compact('currentUser', 'currentAddress', 'countries'));
        }
        return back();
    }

    public function create()
    {
        $currentUser = $this->user;
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        $countries = $this->listCountries();
        return view('members.createaddress', compact('currentUser', 'countries'));
    }

    /**
     * Store a new address
     */
    public function store(Request $request, CustomerAddressValidator $validator)
    {   
        $params = $request->all();
        $validator = $validator->store($params);
         if($validator->fails()){
            return response()->json(['errors' => array_flatten($validator->errors()->toArray())], 422);
        }
        $country = Country::where('code', $params['address_country_name'])->firstOrFail();
        $params['address_country_name'] = $country->name;
        $params['address_country_code'] = $country->code;
        $address = new CustomerAddress;
        $address->fill($params);
        if(!$this->user->addresses()->count()){
            $address->is_billing = 1;
            $address->is_shipping = 1;
        }
        $address->save();
        $this->user->addresses()->save($address);
        return response()->json(['success' => 'Address Created.']);
        
    }

    public function update($id, Request $request, CustomerAddressValidator $validator)
    {
        $params = $request->all();
        $address = CustomerAddress::findOrFail($id);
        $validator = $validator->update($params);
         if($validator->fails()){
            return response()->json(['errors' => array_flatten($validator->errors()->toArray())], 422);
        }
        $country = Country::where('code', $params['address_country_name'])->firstOrFail();
        $params['address_country_name'] = $country->name;
        $params['address_country_code'] = $country->code;
        $address->fill($params);
        $address->save();
        return response()->json(['success' => 'Address updated']);

    }

    protected static function listCountries()
    {
        return Country::orderBy('name')->get(['code', 'name'])->toArray();
    }
    /**
     * @params int $id
     */
    public function billingDefault($id)
    {
        $this->user->load('addresses');
        $address = $this->user->addresses->filter(function($a) use ($id) {
            return $a->id == $id;
        });
        if($address->count()){
            $address = $address->first();
            $currentUser = $this->user;
            $address->setAsBillingFor($currentUser);
        }
        return redirect('members/profile');            
    }

    /**
     * @params int $id
     */
    public function shippingDefault($id)
    {
        $this->user->load('addresses');
        $address = $this->user->addresses->filter(function($a) use ($id) {
            return $a->id == $id;
        });
        if($address->count()){
            $address = $address->first();
            $currentUser = $this->user;
            $address->setAsShippingFor($currentUser);
        }
        return redirect('members/profile');            
    }

    /**
     * @param int $id
     */
    public function deleteAddress($id)
    {
        try {
            $response = CustomerAddress::deleteAddress($id, $this->user);
        } catch (ModelNotFoundException $e) {
            Log::info($e->getMessage());
        }
        if(!$response){
            Log::info('Could not delete address for customer ID# '.$this->user->id);
        }
        return back();  
    }

}