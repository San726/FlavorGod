<?php

use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\StoreCreditAccount;
use Flavorgod\Models\Eloquent\DiscountCode;
use Flavorgod\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
	use DatabaseTransactions;

	// public function test_user_gets_registered_using_regular_form()
	// {
	// 	$registerUserMock = $this->getMockForTrait(Flavorgod\Http\Controllers\Auth\traits\RegistersUsers::class);
	// 	$response = $registerUserMock->createNewUser(['payer_email' => 'foo@bar.com', 'password' => '12345', 'referrer' => 'sample.com']);
	// 	$this->assertInstanceOf('Flavorgod\Models\Eloquent\Customer', $response);
	// 	$customer = Customer::where('payer_email', 'foo@bar.com')->first();
	// 	$this->assertInstanceOf('Flavorgod\Models\Eloquent\Customer', $customer);
	// 	$creditAccount = StoreCreditAccount::where('customer_id', $customer->id)->first();
	// 	$this->assertInstanceOf('Flavorgod\Models\Eloquent\StoreCreditAccount', $creditAccount);
	// 	$discountCode = DiscountCode::where('referrer_customer_id', $customer->id)->first();
	// 	$this->assertInstanceOf('Flavorgod\Models\Eloquent\DiscountCode', $discountCode);
	// }

	// public function test_user_login_does_not_brake_using_regular_form()
	// {
	// 	$registerUserMock = $this->getMockForTrait(Flavorgod\Http\Controllers\Auth\traits\RegistersUsers::class);
	// 	$user = $registerUserMock->createNewUser(['payer_email' => 'foo@bar.com', 'password' => 1234, 'referrer' => 'sample.com']);
	// 	$loginUserMock = $this->getMockForTrait(Flavorgod\Http\Controllers\Auth\traits\AuthenticatesUser::class);
	// 	$response = $loginUserMock->authenticateTheUser(['payer_email' => 'foo@bar.com', 'password' => '1234']);
	// 	$this->assertNull($response);
	// }
}