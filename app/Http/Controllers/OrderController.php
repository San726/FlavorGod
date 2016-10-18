<?php

namespace FLavorgod\Http\Controllers;

use Flavorgod\Models\Eloquent\Order;
use Flavorgod\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Models\Repository\ProductRepository;

class OrderController extends Controller
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
        $currentUser->load('orders.items.productVariant.assets');
        if($currentUser->orders->count()){ 
        	$firstOrder =  $currentUser->orders->first();     
	        $firstAsset = $firstOrder->items->first()->productVariant->assets->filter(function($a){
	        	return $a->pivot->relation_type_name == 'primary_image';
	        })->first();
        }else{
        	$firstAsset = NULL;
        	$firstOrder = NULL;
        }
        $currentUser->shipping_address = $currentUser->getShippingAddress();
        $currentUser->billing_address = $currentUser->getBillingAddress();
        return view('members.orders', compact('currentUser', 'firstAsset', 'firstOrder'));
    }

    public function getOrderDetails($id)
    {
        $order = Order::with('items.productVariant.assets', 'orderStatus', 'carts')->findOrFail($id);
        $order->items = $order->items->groupBy('name');
        $cart = $order->carts->first();
        return response()->json(['success' => 'order returned', 'order' => $order, 'cart' => $cart ]);
    }

}