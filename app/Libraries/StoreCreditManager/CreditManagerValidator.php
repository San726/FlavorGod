<?php 

namespace Flavorgod\Libraries\StoreCreditManager;

use Validator;

class CreditManagerValidator{

	/**
	 * Return a validator instance before we record the store credit transaction
	 * @param array $params 
	 * @return Validator
	 */
	public function storeCreditTransaction($params)
	{
		return Validator::make($params, [
			'cart_id' => 'required',
			'credit_amount' => 'required'
		]);
	}


}