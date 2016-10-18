<?php 

namespace Flavorgod\Libraries\StoreCreditManager;

use DB;
use Carbon\Carbon;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\Order;
use Flavorgod\Models\Eloquent\Discount;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\DiscountCode;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Models\Eloquent\StoreCreditAccount;
use Flavorgod\Models\Eloquent\StoreCreditAdjustment;
use Flavorgod\Models\Eloquent\StoreCreditAdjustmentReason as Reason;

class Manager
{

	 protected $customer;

    /**
     * Set current customer
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }
	/**
     * @param int $cartId
     * @param int $accountId
     * @param double $amount
     * 
     * @return void
     */
    public function recordStoreCreditTransactionToCart($cartId, $accountId, $amount)
    {
        $cart = Cart::with('storeCredits')->findOrFail($cartId);
        if($cart->storeCredits->count()){        
            $entryExists = $this->getStoreCreditEntry($cartId, $accountId);
            if(!empty($entryExists)){//update existing transaction with given cart when not converted
                if($entryExists['converted_at'] == NULL){
                    DB::table('cart_store_credit')->where('cart_id', $entryExists['cart_id'])
                        ->where('store_credit_id', $entryExists['store_credit_id'])
                        ->update(['amount_applied' => $amount, 'updated_at' => Carbon::now(), 'deleted_at' => NULL]);
                }
            }else{//Create newone when theres not transactions with given cart
               DB::table('cart_store_credit')
                ->insert([
                    'cart_id' => $cartId,
                    'store_credit_id' => $accountId,
                    'amount_applied' => $amount,
                    'created_at' => Carbon::now()
                ]);
            }        
        }else{//Create newone when theres not transactions with given cart
            DB::table('cart_store_credit')
                ->insert([
                    'cart_id' => $cartId,
                    'store_credit_id' => $accountId,
                    'amount_applied' => $amount,
                    'created_at' => Carbon::now()
                ]);            
        }
    }

    /**
     * Determine where a credit store entry exists for a given cart
     * @param int $cartId
     * @param int $storeCreditId
     * 
     * @return array
     */
    public function getStoreCreditEntry($cartId, $accountId)
    {
        $entryExists = DB::table('cart_store_credit')
            ->where('cart_id', $cartId)
            ->where('store_credit_id', $accountId)
            ->first();
            return get_object_vars($entryExists);
    }

    /**
     * @param int $accountId
     * @param int $cartId
     * 
     * @return float || null
     */
    public function getStoreCreditAmountAppliedToCart($accountId, $cartId)
    {
        $entryExists = DB::table('cart_store_credit')
            ->where('cart_id', $cartId)
            ->where('store_credit_id', $accountId)
            ->first();
            if($entryExists){
                $entryExists = get_object_vars($entryExists);
                if(!empty($entryExists)){
                    return $entryExists['amount_applied'];
                }                
            }
            return 0.00;
    }

    public function getStoreCreditBalance()
    {
        if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            return $customer->storeCreditAccount->balance;
        }
    }

    /**
     * Clear all pending store credit transactions assigned to given cart
     * @param int $cartId
     * @param int $accountId
     */
    public function removeStoredCreditTransactionFromCart($cartId, $accountId)
    {
    	DB::table('cart_store_credit')->where('cart_id', $cartId)->where('store_credit_id', $accountId)->update(['deleted_at' => Carbon::now()]);
    	return true;
    }

    /**
     * Clear all pending store credit transactions assigned to given cart
     * @param int $cartId
     * @param int $accountId
     */
    public function removeStoredDiscountCodeFromCart($cartId, $discountId)
    {
        DB::table('cart_discount_code')->where('cart_id', $cartId)->where('discount_code_id', $discountId)->update(['deleted_at' => Carbon::now()]);
        return true;
    }

    /**
     * Update the cart discount code table with the converted data
     * 
     * @param $cartId
     */
    public function setCartDiscountCodeToConverted($cartId)
    {
        if($referrer = $this->getReferrerCustomerFromCart($cartId)){
            $referrer->load('referralDiscountCode');
            DB::table('cart_discount_code')
                ->where('cart_id', $cartId)
                ->where('discount_code_id', $referrer->referralDiscountCode->id)
                ->update([
                    'converted_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => NULL//just in case but not necessary
                ]);
        }
    }

    public function setNewReferralForDiscountCode(Customer $customer, $cartId, $discountCodeId)
    {
        if($customer->created_at > Carbon::today()){
            DB::table('cart_discount_code')
                ->where('cart_id', $cartId)
                ->where('discount_code_id', $discountCodeId)
                ->update(['new_referral' =>  1]);
            return true;
        }
        return false;
    }

    /**
     * Update the cart discount code table with the converted data
     * 
     * @param $cartId
     */
    public function setCartStoreCreditToConverted($storeCreditId, $cartId)
    {        
        DB::table('cart_store_credit')
            ->where('cart_id', $cartId)
            ->where('store_credit_id', $storeCreditId)
            ->update([
                'converted_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL//just in case but not necessary
            ]);        
    }

    /**
     * @param array $cart
     * @param int $cartId
     */
    public function getReferrerCustomerFromCart($cartId)
    {
        //return discounts that were not deleted
        $cart = Cart::with(['discounts' => function($q){ 
            $q->whereHas('referrerCustomer', function($query){})->wherePivot('deleted_at', NULL)->get()->sortByDesc('attributed_at');
        }])->findOrFail($cartId);
        $referrers = $cart->discounts->map(function($discount){
            return $discount->referrerCustomer()->first();
        });
        if($referrers->count()){
            return $referrers->first();
        }
        return false;
    }

    /**
     * @param float $amount
     */
    private function updateBalance($amount)
    {
    	if(isset($this->customer)){
    		$customer = $this->getCurrentCustomer();
    		if($customer->storeCreditAccount){
    			$customer->storeCreditAccount->balance = $amount;
    			$customer->storeCreditAccount->save();
    			return $this;
    		}    		
    	}
    	return false;
    }

    /**
     * @param int $customerId // the customer who owns the store account we are adjusting
     * @param 
     * @param int the reason we are making the adjustment
     * @param float $bonusAmount the amount we are increasing/decreasing the account balance by
     */
    public function adjustCustomerStoreBalance
    (
        $customerId, 
        $bonusId,
        $reasonId, 
        $amount
    )
    {
        $customer = Customer::with('storeCreditAccount')->findOrFail($customerId);
        $reason = Reason::findOrFail($reasonId);
        if($reason->default_operation == '-'){
            $balanceAfter = $customer->storeCreditAccount->balance - $amount;
        }else if($reason->default_operation == '+'){
            $balanceAfter  = $customer->storeCreditAccount->balance + $amount;
        }
         $adjustment = StoreCreditAdjustment::create([
            'reason_id' => $reasonId,
            'bonus_id' => $bonusId,
            'store_credit_account_id' => $customer->storeCreditAccount->id,
            'note' => $reason->description,
            'action' => $reason->default_operation,
            'amount' => $amount,
            'balance_before' => $customer->storeCreditAccount->balance,
            'balance_after' => $balanceAfter,
            'created_at' => Carbon::now()
        ]); 
        if($reason->default_operation == '+'){
            $customer->storeCreditAccount->balance =  $customer->storeCreditAccount->balance + $amount;
        }else if($reason->default_operation == '-'){
            $customer->storeCreditAccount->balance =  $customer->storeCreditAccount->balance - $amount;
        }
        $customer->storeCreditAccount->save();
        return $this;     
    }

    /**
     * Update current users store credit balance
     * @param double $amount
     * @param Customer $customer || NULL
     */
    public function updateStoreCreditBalance($amount, Customer $customer = NULL)
    {
    	if(isset($this->customer)){
  			return $this->updateBalance($amount);  
    	}else{
    		if($customer){
	    		return $this->setCustomer($customer)->updateBalance($amount);    	
    		}
    	}
    }

    /**
     * @param $user
     * @param int $cartTotal
     */
    public function getStoreCreditAvailableForCart(Customer $user, $cartTotal)
    {
        $currentCustomer = $this->setCustomer($user)->getCurrentCustomer();
        if($currentCustomer->storeCreditAccount->balance >= 1){
            if($currentCustomer->storeCreditAccount->balance > $cartTotal){
                return $cartTotal;
            }else{
                return $currentCustomer->storeCreditAccount->balance;
            }
        }
        return 0.00;
    }

    /**
     * Create a store credit account and assign it to current customer
     * @return StoreCreditAccount
     * @param Customer
     */
    public function createAndAssignStoreCreditAccountTo(Customer $customer)
    {  
        $account = StoreCreditAccount::where('customer_id', $customer->id)->first();
        if(!$account){
            $account = StoreCreditAccount::create([
                'customer_id' => $customer->id,
                'balance' => 0.00
            ]); 
        }
        return $account; 
    }

    public function getCurrentCustomer()
    {
        if(isset($this->customer)){
            return Customer::with('storeCreditAccount', 'referralDiscountCode')->findOrFail($this->customer->id);
        }
        return false;
    }

}