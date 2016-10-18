<?php

use Carbon\Carbon;
use Flavorgod\Models\Eloquent\Order;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\Customer;
use Illuminate\Database\Eloquent\Collection;
use Flavorgod\Models\Eloquent\DiscountCode;
use Flavorgod\Models\Eloquent\StoreCreditAccount;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Flavorgod\Models\Eloquent\StoreCreditTransaction;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;
use Flavorgod\Models\Eloquent\StoreCreditAdjustment;
use Flavorgod\Models\Eloquent\StoreCreditAdjustmentReason as Reason;

class ReferralProgramTest extends TestCase
{
	use DatabaseTransactions;

    public function test_generate_discount_code()
    {
    	$customer = Customer::create(['payer_email' => 'foo@bar.com']);
    	$program = new ReferralProgram();
    	$code = $program->setCustomer($customer)->generateDiscountCode();
    	$this->assertInternalType('string', $code);
    }

    public function test_create_and_assign_referral_discount_code()
    {
        $customer = Customer::create(['payer_email' => 'foo@bar.com']);
        $program = new ReferralProgram();
        $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
        $customerFromReferral = $program->getCurrentCustomer();
        $customer = Customer::with('referralDiscountCode')->find($customer->id);
        $this->assertEquals($customerFromReferral->referralDiscountCode->code, $customer->referralDiscountCode->code);
    }

    // public function test_create_and_assign_store_credit_account_to_customer()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $this->assertNull($customer->storeCreditAccount);
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $customer = Customer::with('storeCreditAccount')->find($customer->id);
    //     $this->assertInstanceOf(Flavorgod\Models\Eloquent\StoreCreditAccount::class, $customer->storeCreditAccount);
    // }

    // public function test_add_transaction_bonus_to_store_credit_account()
    // {
    //     $referrercustomer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $referralCustomer = Customer::create(['payer_email' => 'bar@foo.com']);
    //     $bonusAmount = ReferralProgram::TRANSACTION_BONUS_AMNT;
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $cart = Cart::create(['sid' => 'foobar']);
    //     $discountCodes = DiscountCode::where('referrer_customer_id', 0)->take(10)->get();
    //     $manager->createAndAssignStoreCreditAccountTo($referrercustomer);
    //     $program->setCustomer($referrercustomer)->createAndAssignReferralDiscountCode();
    //     $referrercustomer = $program->getCurrentCustomer();
    //     $discountCodes->push($referrercustomer->referralDiscountCode);
    //     $discountCodes = $discountCodes->lists('code')->toArray();
    //     $program->processTransactionBonus($referrercustomer->id);
    //     $referrercustomer = $program->getCurrentCustomer();
    //     $this->assertEquals(ReferralProgram::TRANSACTION_BONUS_AMNT, $referrercustomer->storeCreditAccount->balance);
    //     $adjustment = StoreCreditAdjustment::where('store_credit_account_id', $referrercustomer->storeCreditAccount->id)->first();
    //     $this->assertEquals(0, $adjustment->balance_before);
    //     $this->assertEquals(ReferralProgram::TRANSACTION_BONUS_AMNT, $adjustment->balance_after);
    //     $this->assertEquals(ReferralProgram::TRANSACTION_BONUS_AMNT, $adjustment->amount);
    // }
    // public function test_add_gift_card_bonus_per_each_25_transactions_for_first_time()
    // {
    //    $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $createdCarts = new Collection;
    //     foreach (range(1, 25) as $value) {
    //         $createdCarts->push(Cart::create(['sid' => 1]));             
    //      } 
    //     $createdCarts->each(function($cart){
    //         $cart->converted_at = Carbon::now();
    //         $cart->save();
    //      });
    //     $createdCarts->each(function($cart)use($customer){
    //         $cart->discounts()->save($customer->referralDiscountCode);
    //     });
    //     $program->processGiftCardBonus($customer->id);
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $adjustments = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->get();
    //     $adjustment = $adjustments->first();
    //     $this->assertCount(1, $adjustments);
    //     $this->assertEquals(0, $adjustment->balance_after);
    //     $this->assertEquals(0, $adjustment->balance_before);
    //     $this->assertEquals(0, $adjustment->amount);
    // }


    // public function test_add_gift_card_bonus_per_each_25_transactions_for_second_time()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $createdCarts = new Collection;
    //      foreach (range(1, 50) as $value) {
    //         $createdCarts->push(Cart::create(['sid' => 1]));
    //          if($value == 1){
    //             StoreCreditAdjustment::create([
    //                 'reason_id' => ReferralProgram::GIFT_CARD_BONUS_ID,
    //                 'store_credit_account_id' => $customer->storeCreditAccount->id,
    //                 'note' => ReferralProgram::GIFT_CARD_BONUS_DESC,
    //                 'action' => '+',
    //                 'amount' => 0,
    //                 'balance_before' => 0,
    //                 'balance_after' => 0
    //             ]);
    //          }
    //      }
    //      $createdCarts->each(function($cart){
    //         $cart->converted_at = Carbon::now();
    //         $cart->save();
    //      });
    //     $createdCarts->each(function($cart)use($customer){
    //         $cart->discounts()->save($customer->referralDiscountCode);
    //     });
    //     $program->processGiftCardBonus($customer->id);
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $adjustments = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->get();
    //     $this->assertCount(2, $adjustments); 
    // }

    public function test_add_store_credit_bonus_per_each_10_unique_customers_for_first_time()
    {
        $customer = Customer::create(['payer_email' => 'foo@bar.com']);
        $program = new ReferralProgram();
        $manager = new Manager;
        $manager->createAndAssignStoreCreditAccountTo($customer);
        $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
        $customer = $program->setCustomer($customer)->getCurrentCustomer();
        $createdCarts = new Collection;
        foreach (range(1, 10) as $value) {
            $createdcustomer = Customer::create(['payer_email' => $value . '@foo.com']);
            $createdorder = Order::create(['total' => 25.00, 'customer_id' => $createdcustomer->id]);
            $createdcart = Cart::create(['sid' => $value, 'order_id' => $createdorder->id, 'converted_at' => Carbon::now() ]);
            $createdCarts->push($createdcart);
            $createdcart->discounts()->save($customer->referralDiscountCode);
        }
        $createdCarts->each(function($cart){
            $cart->converted_at = Carbon::now();
            $cart->save();
        });
          
        $referredCustomer = Customer::where('payer_email', '9@foo.com')->first();   
        $program->processStoreCreditBonus($customer->id, $referredCustomer->id);
        
        $adjustments = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->get();
        //dd($adjustments);
        // $adjustment = $adjustments->first();
        // dd($adjustment);
        // $this->assertCount(1, $adjustments);
        // $this->assertEquals($adjustment->amount, ReferralProgram::STORE_CREDIT_AMNT); 
        // $this->assertEquals($adjustment->balance_before, 0); 
        // $this->assertEquals($adjustment->balance_after, ReferralProgram::STORE_CREDIT_AMNT); 


    }

    // public function test_add_store_credit_bonus_per_each_10_unique_customers_for_first_second_time()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $createdCarts = new Collection;
    //     foreach (range(1, 20) as $value) {
    //         if($value == 1){
    //             StoreCreditAdjustment::create([
    //                 'reason_id' => ReferralProgram::STORE_CREDIT_ID,
    //                 'store_credit_account_id' => $customer->storeCreditAccount->id,
    //                 'note' => ReferralProgram::STORE_CREDIT_AMNT_DESCRIPTION,
    //                 'action' => '+',
    //                 'amount' => ReferralProgram::STORE_CREDIT_AMNT,
    //                 'balance_before' => 0,
    //                 'balance_after' => ReferralProgram::STORE_CREDIT_AMNT
    //             ]);
    //          }
    //         $createdcustomer = Customer::create(['payer_email' => $value . '@foo.com']);
    //         $createdorder = Order::create(['total' => 25.00, 'customer_id' => $createdcustomer->id]);
    //         $createdcart = Cart::create(['sid' => $value, 'order_id' => $createdorder->id, 'converted_at' => Carbon::now() ]);
    //         $createdCarts->push($createdcart);
    //         $createdcart->discounts()->save($customer->referralDiscountCode);
    //     }
    //     $createdCarts->each(function($cart){
    //         $cart->converted_at = Carbon::now();
    //         $cart->save();
    //     });          
    //     $referredCustomer = Customer::where('payer_email', '9@foo.com')->first();   
    //     $program->processStoreCreditBonus($customer->id, $referredCustomer->id);
    //     $adjustments = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->get();
    //     $this->assertCount(2, $adjustments);  
    // }

    // public function test_select_referrer_customer_from_list_of_discount_codes()
    // {
    //     $createdOrder = Order::create(['total' => 25.00]);
    //     $createdCart = Cart::create(['sid' => 131221, 'order_id' => $createdOrder->id, 'converted_at' => Carbon::now() ]);
    //     $program = new ReferralProgram;
    //     $manager = new Manager;
    //     $createdCustomers = new Collection;
    //     foreach (range(1, 4) as $value) {
    //         $createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
    //         $manager->createAndAssignStoreCreditAccountTo($createdCustomer);
    //         $program->setCustomer($createdCustomer)->createAndAssignReferralDiscountCode();   
    //         $createdCustomers->push($createdCustomer);         
    //     }
    //     $createdCustomers->each(function($customer) use ($createdCart) {
    //         $createdCart->discounts()->save($customer->referralDiscountCode()->first());
    //     });
    //     $referrer = $program->getReferrerCustomerFromCart($createdCart->id);
    //     $this->assertInstanceOf('Flavorgod\Models\Eloquent\Customer', $referrer);
    // }

    // public function test_return_total_referrals_earned_for_account()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $reason = Reason::where('name', 'Store Credit Transaction bonus')->first();
    //     $customer->storeCreditAccount->storeCreditAdjustments()->create([
    //         'reason_id' => $reason->id,
    //         'note' => $reason->description,
    //         'action' => $reason->defult_operation,
    //         'amount' => 5.00,
    //         'balance_before' => $customer->storeCreditAccount->balance,
    //         'balance_after' => $customer->storeCreditAccount->balance + 5.00
    //     ]);
    //     $adjustment = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->first();
    //     $this->assertEquals(5.00, $adjustment->balance_after);
    //     $customer->storeCreditAccount->storeCreditAdjustments()->create([
    //         'reason_id' => $reason->id,
    //         'note' => $reason->description,
    //         'action' => $reason->defult_operation,
    //         'amount' => 5.00,
    //         'balance_before' => 5.00,
    //         'balance_after' => 10.00
    //     ]);
    //     $secondProgram = new ReferralProgram;
    //     $amount = $secondProgram->setCustomer($customer)->getTotalReferralsEarned();
    //     $this->assertEquals($amount, 10.00);
    // }

    // public function test_return_total_bonuses_earned_for_account()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $reason = Reason::where('name', 'Store Credit Bonus')->first();
    //     $customer->storeCreditAccount->storeCreditAdjustments()->create([
    //         'reason_id' => $reason->id,
    //         'note' => $reason->description,
    //         'action' => $reason->defult_operation,
    //         'amount' => 100.00,
    //         'balance_before' => $customer->storeCreditAccount->balance,
    //         'balance_after' => $customer->storeCreditAccount->balance + 100.00
    //     ]);
    //     $adjustment = StoreCreditAdjustment::where('store_credit_account_id', $customer->storeCreditAccount->id)->first();
    //     $this->assertEquals(100.00, $adjustment->balance_after);
    //     $customer->storeCreditAccount->storeCreditAdjustments()->create([
    //         'reason_id' => $reason->id,
    //         'note' => $reason->description,
    //         'action' => $reason->defult_operation,
    //         'amount' => 100.00,
    //         'balance_before' => 100.00,
    //         'balance_after' => 200.00
    //     ]);
    //     $secondProgram = new ReferralProgram;
    //     $amount = $secondProgram->setCustomer($customer)->getTotalBonusesEarned();
    //     $this->assertEquals($amount, 200.00);
    // }

    // public function test_return_total_giftcards_earned_for_account()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $reason = Reason::where('name', 'Gift Card Bonus')->first();
    //     $customer->storeCreditAccount->storeCreditAdjustments()->create([
    //         'reason_id' => $reason->id,
    //         'note' => $reason->description,
    //         'action' => $reason->defult_operation,
    //         'amount' => 0.00,
    //         'balance_before' => $customer->storeCreditAccount->balance,
    //         'balance_after' => $customer->storeCreditAccount->balance + 0.00
    //     ]);       
    //     $secondProgram = new ReferralProgram;
    //     $amount = $secondProgram->setCustomer($customer)->getTotalGiftCardsEarned();
    //     $this->assertEquals($amount, 1);
    // }

    // public function test_return_collection_of_referrals_for_account()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $createdCarts = new Collection;
    //     foreach (range(1, 20) as $value) {
    //         if($value == 1){
    //             StoreCreditAdjustment::create([
    //                 'reason_id' => ReferralProgram::STORE_CREDIT_ID,
    //                 'store_credit_account_id' => $customer->storeCreditAccount->id,
    //                 'note' => ReferralProgram::STORE_CREDIT_AMNT_DESCRIPTION,
    //                 'action' => '+',
    //                 'amount' => ReferralProgram::STORE_CREDIT_AMNT,
    //                 'balance_before' => 0,
    //                 'balance_after' => ReferralProgram::STORE_CREDIT_AMNT
    //             ]);
    //          }
    //         $createdcustomer = Customer::create(['payer_email' => $value . '@foo.com']);
    //         $createdorder = Order::create(['total' => 25.00, 'customer_id' => $createdcustomer->id]);
    //         $createdcart = Cart::create(['sid' => $value, 'order_id' => $createdorder->id, 'converted_at' => Carbon::now() ]);
    //         $createdCarts->push($createdcart);
    //         $createdcart->discounts()->save($customer->referralDiscountCode);
    //     }
    //     $createdCarts->each(function($cart){
    //         $cart->converted_at = Carbon::now();
    //         $cart->save();
    //     });          
    //     $referredCustomer = Customer::where('payer_email', '9@foo.com')->first();   
    //     $program->processStoreCreditBonus($customer->id, $referredCustomer->id);
    //     $newProgram = new ReferralProgram;
    //     $customersList = $newProgram->setCustomer($customer)->getReferrals();
    //     $this->assertCount(20, $customersList);         
    // }

    // public function test_return_recent_orders_for_account()
    // {
    //     $customer = Customer::create(['payer_email' => 'foo@bar.com']);
    //     $program = new ReferralProgram();
    //     $manager = new Manager;
    //     $manager->createAndAssignStoreCreditAccountTo($customer);
    //     $program->setCustomer($customer)->createAndAssignReferralDiscountCode();
    //     $customer = $program->setCustomer($customer)->getCurrentCustomer();
    //     $createdCarts = new Collection;
    //     foreach (range(1, 20) as $value) {
    //         if($value == 1){
    //             StoreCreditAdjustment::create([
    //                 'reason_id' => ReferralProgram::STORE_CREDIT_ID,
    //                 'store_credit_account_id' => $customer->storeCreditAccount->id,
    //                 'note' => ReferralProgram::STORE_CREDIT_AMNT_DESCRIPTION,
    //                 'action' => '+',
    //                 'amount' => ReferralProgram::STORE_CREDIT_AMNT,
    //                 'balance_before' => 0,
    //                 'balance_after' => ReferralProgram::STORE_CREDIT_AMNT
    //             ]);
    //          }
    //         $createdcustomer = Customer::create(['payer_email' => $value . '@foo.com']);
    //         $createdorder = Order::create(['total' => 25.00, 'customer_id' => $createdcustomer->id]);
    //         $createdcart = Cart::create(['sid' => $value, 'order_id' => $createdorder->id, 'converted_at' => Carbon::now() ]);
    //         $createdCarts->push($createdcart);
    //         $createdcart->discounts()->save($customer->referralDiscountCode);
    //     }
    //     $createdCarts->each(function($cart){
    //         $cart->converted_at = Carbon::now();
    //         $cart->save();
    //     });          
    //     $referredCustomer = Customer::where('payer_email', '9@foo.com')->first();   
    //     $program->processStoreCreditBonus($customer->id, $referredCustomer->id);
    //     $newProgram = new ReferralProgram;
    //     $orders = $newProgram->setCustomer($customer)->getRecentOrders(5);
    //     $this->assertCount(5, $orders);  
    // }

}
