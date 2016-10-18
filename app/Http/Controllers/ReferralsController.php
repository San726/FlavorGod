<?php
namespace FLavorgod\Http\Controllers;

use Illuminate\Http\Request;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Http\Controllers\Controller;
use Flavorgod\Models\Repository\ProductRepository;

class ReferralsController extends Controller
{
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

    public function index()
    {
    	$currentUser = $this->user;
        $this->setViewName('profileshow');
        $this->setTitleName('manage my account');
        $currentUser = $currentUser->withCustomerReferralData();
        return view('members.referralprogram', compact('currentUser'));           	
    }

}