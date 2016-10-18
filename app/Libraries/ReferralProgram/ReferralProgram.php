<?php 

namespace Flavorgod\Libraries\ReferralProgram;

use DB;
use Event;
use Carbon\Carbon;
use Flavorgod\Events\GiftCardBonusEarned;
use Flavorgod\Events\TransactionBonusEarned;
use Flavorgod\Events\StoreCreditBonusEarned;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\Discount;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\DiscountCode;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Models\Eloquent\StoreCreditAdjustment;

class ReferralProgram
{
	const REFERRAL_DISCOUNT_TERM = 9;
    
    const TRANSACTION_BONUS_ID = 3;
    const TRANSACTION_BONUS_AMNT = 5;
    const TRANSACTION_BONUS_DESCRIPTION = '$5 dollar transaction bonus.';

    const STORE_CREDIT_ID = 2;
    const STORE_CREDIT_AMNT = 100;
    const STORE_CREDIT_AMNT_DESCRIPTION = '$100 dollar store bonus';

    const GIFT_CARD_BONUS_ID = 1;
    const GIFT_CARD_BONUS_DESC = 'Amazon Gift card bonus';

    const GIFT_CARD_BONUS_REASON_ID = 1;
    const STORE_CREDIT_BONUS_REASON_ID = 2;
    const TRANSACTION_BONUS_REASON_ID = 3;
    const ADD_STORE_CREDIT_REASON = 4;
    const DEDUCT_STORE_CREDIT_REASON = 6;


    protected $customer;
    protected $manager;

    public function __construct()
    {
        $this->manager = new Manager;
    }

    /**
     * Set current customer
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }  

    /**
     * Create store disount code and assign it to customer
     * @return Static
     */
    public function createAndAssignReferralDiscountCode()
    {
        if(isset($this->customer)){
            $codeExists = DiscountCode::where('referrer_customer_id', $this->customer->id)->first();
            if(!$codeExists){
            	$code = $this->generateDiscountCode();
            	 $discountCode = DiscountCode::create([
                    'code' => $code,
                    'enabled' => 1
                ]);
            	$discount = Discount::findOrFail(self::REFERRAL_DISCOUNT_TERM);
                $discount->codes()->save($discountCode);
                $this->customer->referralDiscountCode()->save($discountCode);                
            }
            return $this;
        }
        return false;
    }
    
    /**
     * Get the amount in dollars from the amount of referrals
     */
    public function getTotalReferralsEarned()
    {
        if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            $customer->storeCreditAccount->load(['storeCreditAdjustments' => function($a){
                $a->where('reason_id', self::TRANSACTION_BONUS_REASON_ID);
            }]);
        }
        return $this->getAdjustmentsTotal($customer); 
    }

    public function getTotalReferralsEarnedCount()
    {
        if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            $customer->storeCreditAccount->load(['storeCreditAdjustments' => function($a){
                $a->where('reason_id', self::TRANSACTION_BONUS_REASON_ID);
            }]);
            if($count = $customer->storeCreditAccount->storeCreditAdjustments->count()){
                return $count;
            }
            return 0;
        }        
    }

    public function setCustomertoValidateStoreCreditBonus(Customer $customer, $cartId, $referrer)
    {
        $referrer->load('referralDiscountCode');
        return $this->manager->setNewReferralForDiscountCode($customer, $cartId, $referrer->referralDiscountCode->id);
    }

     
    public function getTotalGiftCardsEarned()
    {
        if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            $customer->storeCreditAccount->load(['storeCreditAdjustments' => function($a){
                $a->where('reason_id', self::GIFT_CARD_BONUS_REASON_ID);
            }]);
        }
         if($count = $customer->storeCreditAccount->storeCreditAdjustments->count()){
            return $count;
         }
         return 0;
    }

    public function getTotalBonusesEarned()
    {
         if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            $customer->storeCreditAccount->load(['storeCreditAdjustments' => function($a){
                $a->where('reason_id', self::STORE_CREDIT_BONUS_REASON_ID);
            }]);
        }
        return $this->getAdjustmentsTotal($customer);  
    }

    public function getTotalBonusesEarnedCount()
    {
         if(isset($this->customer)){
            $customer = $this->getCurrentCustomer();
            $customer->storeCreditAccount->load(['storeCreditAdjustments' => function($a){
                $a->where('reason_id', self::STORE_CREDIT_BONUS_REASON_ID);
            }]);
        }
        if($count = $customer->storeCreditAccount->storeCreditAdjustments->count()){
            return $count;
         }
         return 0;         
    }

    private function getAdjustmentsTotal(Customer $customer)
    {        
        if($customer->storeCreditAccount->storeCreditAdjustments->count()){
            $amountsEarned = $customer->storeCreditAccount->storeCreditAdjustments->lists('amount');
            return $amountsEarned->sum();
        }        
        return 0.00;
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

    public function getCurrentCustomer()
    {
        if(isset($this->customer)){
            return Customer::with('storeCreditAccount', 'referralDiscountCode')->findOrFail($this->customer->id);
        }
        return false;
    }
    
    public function generateDiscountCode()
    {
    	if($this->customer->first_name){
            $firstName = $this->customer->first_name;
            $lastName = $this->customer->last_name ? : '';
        }else if($this->customer->address_name){
            $nameParts = $this->customer->addressNameLines();
            if(!empty($nameParts)){
                $firstName = $nameParts[0]; 
                $lastName = array_key_exists(1, $nameParts)? $nameParts[1]: '';
            }else{
                $firstName = substr(sha1(time(). $this->customer->id), 0, 4);
                $lastName = substr(sha1(time(). $this->customer->id), 0, 4);
            }
        }else if($this->customer->payer_email){
            $firstName = $this->customer->emailAddressLines();
            $lastName = substr(sha1(time(). $this->customer->id), 0, 4);
        }else{
           $firstName = substr(sha1(rand() . time(). $this->customer->id), 0, 4);
            $lastName = substr(sha1(time(). $this->customer->id), 0, 4); 
        }
        $lastName = empty($lastName) ? substr(sha1(time() . $this->customer->id), 0, 5) : substr($lastName, 0, 1) . substr(sha1(time() . $this->customer->id), 0, 4);
        $customerCode = strtolower($firstName . $lastName); 
        return trim(str_replace(' ', '', strtoupper($customerCode))); 
    }

    /**
     * @param int $customerId // the customer who owns the store account we are adjusting
     * @param 
     * @param int the reason we are making the adjustment
     * @param float $bonusAmount the amount we are increasing/decreasing the account balance by
     */
    public function updateCustomerStoreBalance
    (
        $customerId, 
        $bonusId,
        $reasonId, 
        $amount
    )
    {
        $this->manager->adjustCustomerStoreBalance($customerId, $bonusId, $reasonId, $amount);
        return $this;            
    }

    /**
     * @param int $customerId
     * @param float $amount
     */
    public function processStoreCreditDeduction($customerId, $amount)
    {
        return $this->updateCustomerStoreBalance(
            $customerId,
            NULL,
            self::DEDUCT_STORE_CREDIT_REASON,
            $amount
        );
    }

    /**
     * @param $accountId
     */
    public function processTransactionBonus($customer)
    {
        $updated = $this->updateCustomerStoreBalance(
            $customer->id, 
            self::TRANSACTION_BONUS_ID, 
            self::TRANSACTION_BONUS_REASON_ID, 
            self::TRANSACTION_BONUS_AMNT 
        );
         Event::fire(new TransactionBonusEarned($customer));
         return $updated;
    }
    /**
     * @return Collection
     */
    public function getReferrals()
    {
        if(isset($this->customer)){
            $this->customer->load('referralDiscountCode.carts.order.customer');
            $uniqueCustomersByCoupon = $this->customer->referralDiscountCode->carts->map(function($cart){
                if($cart->pivot->new_referral == 1 && $cart->pivot->converted_at != NULL){
                    return $cart->order->customer;
                }
            }); 
            $results = $uniqueCustomersByCoupon->filter(function($u){
                            if($u){
                                return true;
                            }
                        });

            return $results;
        }
    }

    /**
     * @param $accountId
     */
    public function processStoreCreditBonus($referrerCustomerId, $referredCustomerId)
    {
        $referrerCustomer = Customer::with('storeCreditAccount', 'referralDiscountCode.carts.order.customer')->findOrFail($referrerCustomerId);
        $uniqueCustomersByCoupon = $referrerCustomer->referralDiscountCode->carts->map(function($cart){
            if($cart->pivot->new_referral && $cart->pivot->converted_at != NULL){
                return $cart->order->customer;               
            }           
        })->unique('id')->lists('id');
        if($uniqueCustomersByCoupon->count()){
            $newCustomer = Customer::whereNotIn('id', $uniqueCustomersByCoupon->toArray())->find($referredCustomerId); 
            if($newCustomer){
                if($newCustomer->created_at > Carbon::today())//New users only
                {
                     $storeBonusCount = number_format(floor($uniqueCustomersByCoupon->count()/9));
                     $storeCreditsEarnedBefore = StoreCreditAdjustment::where('reason_id', self::STORE_CREDIT_BONUS_REASON_ID)
                         ->where('store_credit_account_id', $referrerCustomer->storeCreditAccount->id)
                         ->get();
                    $storeBonusCount = intval($storeBonusCount);                 
                    if(
                    $storeBonusCount > 0
                    && $storeBonusCount > $storeCreditsEarnedBefore->count()
                    && $storeBonusCount - $storeCreditsEarnedBefore->count() == 1
                    )
                    {
                        $updated = $this->updateCustomerStoreBalance(
                            $referrerCustomerId, 
                            self::STORE_CREDIT_ID, 
                            self::STORE_CREDIT_BONUS_REASON_ID, 
                            self::STORE_CREDIT_AMNT
                        ); 
                        if($updated instanceof ReferralProgram){                 
                            Event::fire(new StoreCreditBonusEarned($referrerCustomer));
                        }
                    }
                }   
            }      
        }       
        return $this;
    }


    /**
     * @param StoreCreditAccont $storeCreditAccount
     */
    public function processGiftCardBonus($referrerCustomerId)
    {
        $currentCustomer = Customer::with('storeCreditAccount', 'referralDiscountCode.carts')->findOrFail($referrerCustomerId);
        $transactionCount = $currentCustomer->referralDiscountCode->carts->filter(function($cart){
            if($cart->pivot->new_referral && $cart->pivot->converted_at != NULL){
                return true;
            }
        });
        if($transactionCount->count()){
            $transactionCount = number_format(floor($transactionCount->count()/24));
            $giftCardBonusesEarnedBefore = StoreCreditAdjustment::where('reason_id', self::GIFT_CARD_BONUS_REASON_ID)
                ->where('store_credit_account_id', $currentCustomer->storeCreditAccount->id)
                ->get();
                $transactionCount = intval($transactionCount);
                if(
                $transactionCount > 0 
                && $transactionCount > $giftCardBonusesEarnedBefore->count() 
                && $transactionCount - $giftCardBonusesEarnedBefore->count() == 1
                ){
                $updated = $this->updateCustomerStoreBalance(
                    $referrerCustomerId, 
                    self::GIFT_CARD_BONUS_ID, 
                    self::GIFT_CARD_BONUS_REASON_ID, 
                    0
                );
                if($updated instanceof ReferralProgram){                 
                    Event::fire(new GiftCardBonusEarned($currentCustomer));
                }
             }
        }
        return $this;  
    }    
}
