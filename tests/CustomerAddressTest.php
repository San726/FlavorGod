<?php 

use Flavorgod\Models\Eloquent\Customer;
use Flavorgod\Models\Eloquent\CustomerAddress;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Collection;
class CustomerAddressTest extends TestCase
{
	use DatabaseTransactions;

	public function test_creating_new_address_and_assigning_it_to_existing_customer()
	{
		$customer = Customer::create([
			'payer_email' => 'foo@bar.com',
			'address_name' => 'foo',
			'first_name' => 'bar',
			'address_street' => '123 great street',
			'address_city' => 'super city',
			'address_state' => 'NJ',
			'address_zip' => 10040,
			'address_phone' => '2122222222',
			'contact_phone' => '9999999999',
			'address_country_code' => 'US',
			'address_country_name' => 'United States',
			'address_country' => 'United States',
			'contact_phone' => '9999999999'
		]);
		$address = new CustomerAddress;
		$response = $address->createAndAssignTo($customer);
		$customer = $customer->with('addresses')->find($customer->id);
		$this->assertCount(1, $customer->addresses);
		$createdAddress = $customer->addresses->first();
		$this->assertEquals(1, $createdAddress->is_billing);
		$this->assertEquals(1, $createdAddress->is_shipping);

	}

	public function test_set_address_as_default_billing()
	{
		$customer = Customer::create([
			'payer_email' => 'foo@bar.com',
			'address_name' => 'foo',
			'first_name' => 'bar',
			'address_street' => '123 great street',
			'address_city' => 'super city',
			'address_state' => 'NJ',
			'address_zip' => 10040,
			'address_phone' => '2122222222',
			'contact_phone' => '9999999999',
			'address_country_code' => 'US',
			'address_country_name' => 'United States',
			'address_country' => 'United States',
			'contact_phone' => '9999999999'
		]);
		$createdAddresses = new Collection;
		foreach (range(1,3) as $value) {
			$address = CustomerAddress::create([
				'customer_id' => $customer->id,
		        'address_name' => '123 best street',
		        'address_company' => '123 Company',
		        'address_street' => '123 address street',
		        'address_city' => 'new york',
		        'address_state' => 'NY',
		        'address_zip' => 10040,
		        'is_billing' => $value == 1? 1 : NULL,
		        'is_shipping' => $value == 1 ? 1 : NULL,
		        'address_phone' => '1111111111',
		        'address_country_code' => 'USA',
		        'address_country_name' => 'United states'
			]);
			$createdAddresses->push($address);
		}
		$lastAddress = $createdAddresses->last();
		$firstAddress = $createdAddresses->first();
		$this->assertEquals(1, $firstAddress->is_billing);
		$this->assertEquals(1, $firstAddress->is_shipping);
		$this->assertNull($lastAddress->is_shipping);
		$this->assertNull($lastAddress->is_billing);
		$response = $lastAddress->setAsBillingFor($customer);
		$this->assertTrue($response);
		$firstAddress = CustomerAddress::find($firstAddress->id);
		$thirdAddress = CustomerAddress::find($lastAddress->id);
		$this->assertNull($firstAddress->is_billing);
		$this->assertEquals(1, $thirdAddress->is_billing);
	}

	public function test_set_address_as_default_shipping()
	{
		$customer = Customer::create([
			'payer_email' => 'foo@bar.com',
			'address_name' => 'foo',
			'first_name' => 'bar',
			'address_street' => '123 great street',
			'address_city' => 'super city',
			'address_state' => 'NJ',
			'address_zip' => 10040,
			'address_phone' => '2122222222',
			'contact_phone' => '9999999999',
			'address_country_code' => 'US',
			'address_country_name' => 'United States',
			'address_country' => 'United States',
			'contact_phone' => '9999999999'
		]);
		$createdAddresses = new Collection;
		foreach (range(1,3) as $value) {
			$address = CustomerAddress::create([
				'customer_id' => $customer->id,
		        'address_name' => '123 best street',
		        'address_company' => '123 Company',
		        'address_street' => '123 address street',
		        'address_city' => 'new york',
		        'address_state' => 'NY',
		        'address_zip' => 10040,
		        'is_billing' => $value == 1? 1 : NULL,
		        'is_shipping' => $value == 1 ? 1 : NULL,
		        'address_phone' => '1111111111',
		        'address_country_code' => 'USA',
		        'address_country_name' => 'United states'
			]);
			$createdAddresses->push($address);
		}
		$lastAddress = $createdAddresses->last();
		$firstAddress = $createdAddresses->first();
		$this->assertEquals(1, $firstAddress->is_shipping);
		$this->assertEquals(1, $firstAddress->is_shipping);
		$this->assertNull($lastAddress->is_shipping);
		$this->assertNull($lastAddress->is_billing);
		$response = $lastAddress->setAsShippingFor($customer);
		$this->assertTrue($response);

		$firstAddress = CustomerAddress::find($firstAddress->id);
		$thirdAddress = CustomerAddress::find($lastAddress->id);
		$this->assertNull($firstAddress->is_shipping);
		$this->assertEquals(1, $thirdAddress->is_shipping);
	}

	public function test_set_address_as_primary_address()
	{
		$customer = Customer::create([
			'payer_email' => 'foo@bar.com',
			'address_name' => 'foo',
			'first_name' => 'bar',
			'address_street' => '123 great street',
			'address_city' => 'super city',
			'address_state' => 'NJ',
			'address_zip' => 10040,
			'address_phone' => '2122222222',
			'contact_phone' => '9999999999',
			'address_country_code' => 'US',
			'address_country_name' => 'United States',
			'address_country' => 'United States',
			'contact_phone' => '9999999999'
		]);
		$createdAddresses = new Collection;
		foreach (range(1,3) as $value) {
			$address = CustomerAddress::create([
				'customer_id' => $customer->id,
		        'address_name' => '123 best street',
		        'address_company' => '123 Company',
		        'address_street' => '123 address street',
		        'address_city' => 'new york',
		        'address_state' => 'NY',
		        'address_zip' => 10040,
		        'is_billing' => $value == 1? 1 : NULL,
		        'is_shipping' => $value == 1 ? 1 : NULL,
		        'address_phone' => '1111111111',
		        'address_country_code' => 'USA',
		        'address_country_name' => 'United states'
			]);
			$createdAddresses->push($address);
		}
		$lastAddress = $createdAddresses->last();
		$firstAddress = $createdAddresses->first();
		$secondAddress = $createdAddresses[1];
		$response = $lastAddress->setAsPrimaryFor($customer);
		$lastAddress = CustomerAddress::find($lastAddress->id);
		$firstAddress = CustomerAddress::find($firstAddress->id);
		$secondAddress = CustomerAddress::find($secondAddress->id);
		$this->assertNull($firstAddress->is_shipping);
		$this->assertNull($firstAddress->is_billing);
		$this->assertNull($secondAddress->is_shipping);
		$this->assertNull($secondAddress->is_billing);
		$this->assertEquals(1, $lastAddress->is_billing);
		$this->assertEquals(1, $lastAddress->is_shipping);

	}

	


}

