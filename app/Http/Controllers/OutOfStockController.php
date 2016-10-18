<?php

namespace Flavorgod\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Flavorgod\Models\Eloquent\User;
use Flavorgod\Models\Eloquent\VipList as VipListMember;
use Flavorgod\Models\Eloquent\OutOfStock;
use Flavorgod\Http\Controllers\Controller;


class OutOfStockController extends Controller
{

	public function store(Request $request)
	{
		$validator = $this->validator($request->all());
		if($validator->fails()){
			return response()->json($validator->errors(), 422);
		}
		$vipList = VipListMember::where('email', $request->input('email'))->first();
		if($vipList){
			$alreadySubscribed = OutOfStock::where('viplist_id', $vipList->id)->where('variant_sku', $request->input('variant_sku'))->first();
			if(!$alreadySubscribed){
				$outOfStockItem = OutOfStock::create($request->all());
				$vipList->outOfStock()->save($outOfStockItem);
				return response()->json(['success' => 'Great! We will notify you when this is back in stock!'], 200);
			}
			return response()->json(['success' => 'Great! We will notify you when this is back in stock!'], 200);	
		}else{
			$vipListMember = $this->subscribeToVip($request);
			$outOfStockItem = OutOfStock::create($request->all());
			$vipListMember->outOfStock()->save($outOfStockItem);
			return response()->json(['success' => 'Great! We will notify you when this is back in stock!'], 200);
		}
	}

	/**
     * Subscribe a new member to the vip List
     * @param Request $request
     */
    private function subscribeToVip($request)
    {
        $user = User::byEmail($request->input('email'));
         if($user){
            $vip = VipListMember::create($request->all());
            $user->vip()->save($vip);
            return $vip;
        }else{
            $vip = VipListMember::create($request->all());
            return $vip;
        }
    }



	/**
	 * Create a new validator instance
	 * To create a new Out of stock model
	 */
	public function validator($data)
	{
		return Validator::make($data, [
			'email' => 'email|required',
			'variant_sku' => 'required',
			'product_url' => 'required'
		]);
	}
}