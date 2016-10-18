<?php

use Carbon\Carbon;
use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\Cart;
use Flavorgod\Models\Eloquent\StoreCreditAccount;
use Flavorgod\Libraries\StoreCreditManager\Manager;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreCreditManagerTest extends TestCase
{
	// use DatabaseTransactions;

	// public function test_adding_transaction_record_to_cart_and_store_credit_account()
	// {
	// 	$program = new ReferralProgram;
	// 	$manager = new Manager;
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
 //        $createdCart = Cart::create(['sid' => 131221 ]);
 //        $manager->createAndAssignStoreCreditAccountTo($createdCustomer);
 //        $program->setCustomer($createdCustomer)->createAndAssignReferralDiscountCode();
 //        $customer = $program->setCustomer($createdCustomer)->getCurrentCustomer();
 //        $manager->recordStoreCreditTransactionToCart($createdCart->id, $customer->storeCreditAccount->id, 25);
 //        $createdCart->load('storeCredits');
 //        $customer->storeCreditAccount->load('carts');
 //        $this->assertCount(1, $createdCart->storeCredits);
 //        $this->assertCount(1, $customer->storeCreditAccount->carts);
	// }

	// public function test_updating_an_existing_transaction_record_related_to_a_store_credit_account_and_cart()
	// {
	// 	$program = new ReferralProgram;
	// 	$manager = new Manager;
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
 //        $createdCart = Cart::create(['sid' => 131221 ]);
 //        $manager->createAndAssignStoreCreditAccountTo($createdCustomer);
 //        $program->setCustomer($createdCustomer)->createAndAssignReferralDiscountCode();
 //        $customer = $program->setCustomer($createdCustomer)->getCurrentCustomer();
 //        $manager->recordStoreCreditTransactionToCart($createdCart->id, $customer->storeCreditAccount->id, 25);
 //        $transaction = DB::table('cart_store_credit')
 //        	->where('cart_id', $createdCart->id)
 //        	->where('store_credit_id', $customer->storeCreditAccount->id)
 //        	->where('amount_applied', 25)
 //        	->first();
 //        $this->assertEquals(25, get_object_vars($transaction)['amount_applied']);
 //        $manager->recordStoreCreditTransactionToCart($createdCart->id, $customer->storeCreditAccount->id, 35);
 //        $transaction = DB::table('cart_store_credit')
 //        	->where('cart_id', $createdCart->id)
 //        	->where('store_credit_id', $customer->storeCreditAccount->id)
 //        	->where('amount_applied', 35)
 //        	->first();
 //        $createdCart->load('storeCredits');
 //        $customer->storeCreditAccount->load('carts');
 //        $this->assertEquals(35, get_object_vars($transaction)['amount_applied']);
 //        $this->assertCount(1, $createdCart->storeCredits);
 //        $this->assertCount(1, $customer->storeCreditAccount->carts);
	// }

	// public function test_removing_all_pending_transaction_from_store_credit_and_cart()
	// {
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
	// 	$manager = new Manager;
	// 	$cart = Cart::create(['sid' => 'foobar']);
	// 	$manager->createAndAssignStoreCreditAccountTo($createdCustomer);
	// 	$createdCustomer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();
	// 	$manager->recordStoreCreditTransactionToCart($cart->id, $createdCustomer->storeCreditAccount->id, 25.00);
	// 	$createdCustomer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();
	// 	$createdCustomer->storeCreditAccount->load('carts');
	// 	$cart->load('storeCredits');
	// 	$this->assertCount(1, $cart->storeCredits);
 //  		$this->assertCount(1, $createdCustomer->storeCreditAccount->carts);
	// 	$manager->removeStoredCreditTransactionFromCart($cart->id, $createdCustomer->storeCreditAccount->id);
	// 	$createdCustomer->storeCreditAccount->load('carts');
	// 	$cart->load('storeCredits');
	// 	$this->assertCount(0, $cart->storeCredits);
 //  		$this->assertCount(0, $createdCustomer->storeCreditAccount->carts);
	// }

	// public function test_update_store_credit_balance_by_amount()
	// {
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
	// 	$manager = new Manager;
	// 	$manager->createAndAssignStoreCreditAccountTo($createdCustomer);
	// 	$customer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();
	// 	$this->assertEquals(0, $customer->storeCreditAccount->balance);
	// 	$manager->updateStoreCreditBalance(15.00, $customer);
	// 	$customer = $manager->getCurrentCustomer();
	// 	$this->assertEquals(15.00, $customer->storeCreditAccount->balance);
	// }

	// public function test_return_correct_amount_when_cart_total_is_less_than_balance()
	// {
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
	// 	$manager = new Manager;
	// 	$manager->createAndAssignStoreCreditAccountTo($createdCustomer);
	// 	$customer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();
	// 	$manager->updateStoreCreditBalance(100.00, $customer);
	// 	$cartTotal = 25.00;
	// 	$response = $manager->getStoreCreditAvailableForCart($customer, $cartTotal);
	// 	$this->assertEquals($response, $cartTotal);
	// }

	// public function test_return_correct_amount_when_cart_total_is_greater_than_balance()
	// {
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
	// 	$manager = new Manager;
	// 	$manager->createAndAssignStoreCreditAccountTo($createdCustomer);
	// 	$customer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();
	// 	$manager->updateStoreCreditBalance(50.00, $customer);
	// 	$account = StoreCreditAccount::where('customer_id', $customer->id)->first();
	// 	$cartTotal = 100.00;
	// 	$response = $manager->getStoreCreditAvailableForCart($customer, $cartTotal);
	// 	$this->assertEquals($response, $account->balance);
	// }

	// public function test_return_false_when_account_balance_is_zero()
	// {
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
	// 	$manager = new Manager;
	// 	$manager->createAndAssignStoreCreditAccountTo($createdCustomer);
	// 	$customer = $manager->setCustomer($createdCustomer)->getCurrentCustomer();		
	// 	$account = StoreCreditAccount::where('customer_id', $customer->id)->first();
	// 	$cartTotal = 100.00;
	// 	$response = $manager->getStoreCreditAvailableForCart($customer, $cartTotal);
	// 	$this->assertEquals(0.00, $response);
	// }

	// public function test_return_applied_store_credit_for_cart()
	// {
	// 	$program = new ReferralProgram;
	// 	$manager = new Manager;
	// 	$createdCustomer = Customer::create(['payer_email' => 'foo@bar.com']);
 //        $createdCart = Cart::create(['sid' => 131221 ]);
 //        $manager->createAndAssignStoreCreditAccountTo($createdCustomer);
 //        $program->setCustomer($createdCustomer)->createAndAssignReferralDiscountCode();
 //        $customer = $program->setCustomer($createdCustomer)->getCurrentCustomer();
 //        $manager->recordStoreCreditTransactionToCart($createdCart->id, $customer->storeCreditAccount->id, 25);
 //        $createdCart->load('storeCredits');
 //        $customer->storeCreditAccount->load('carts');
 //        $this->assertCount(1, $createdCart->storeCredits);
 //        $this->assertCount(1, $customer->storeCreditAccount->carts);
 //        $amount = $manager->getStoreCreditAmountAppliedToCart($customer->storeCreditAccount->id, $createdCart->id);
 //        $this->assertEquals(25, $amount);
	// }

}