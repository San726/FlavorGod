<?php

namespace Flavorgod\Models\Eloquent;

use Flavorgod\Models\Eloquent\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerAddress extends Model
{
	 /**
     * The table used by the model
     */
    protected $table = 'addresses';

    protected $fillable = [
        'customer_id',
        'address_name',
        'address_company',
        'address_street',
        'address_street2',
        'address_city',
        'address_zip',
        'is_billing',
        'is_shipping',
        'address_phone',
        'address_state',
        'address_country_code',
        'address_country_name'
   ];

    /**
    * An address belongs to a customer
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function getBilling($user)
    {
        if($user->addresses()->count()){
            $billing = $user->addresses->filter(function($a){
                return $a->is_billing == 1;
            });
            return $billing->first();
        }
        return null;
    }

    public static function getShipping($user)
    {
        if($user->addresses()->count()){
            $shipping = $user->addresses->filter(function($a){
                return $a->is_shipping == 1;
            });
            return $shipping->first();
        }
        return null;
    }

    /**
     * @param Customer $customer
     * @param int | NULL $isPrimary
     */
    public function createAndAssignTo(Customer $customer, $isPrimary = NULL)
    {
        $hasAddresses = $customer->addresses()->count();
        $address = $this->makeNew($customer->toArray());
        $hasThisAddress = $customer->addresses()->where('address_street', $customer->address_street)->first();
        if(!$hasThisAddress){
            if(!$hasAddresses){
                $address->is_billing = 1;
                $address->is_shipping = 1;
                $customer->addresses()->save($address); 
            }else{
                if($isPrimary){
                    $this->resetBillingAndShippingFor($customer);
                    $address->is_billing = 1;
                    $address->is_shipping = 1;
                    $customer->addresses()->save($address);            
                }else{
                    $customer->addresses()->save($address);
                }            
            }
        }
        return true;
    }

    private function resetBillingAndShippingFor(Customer $customer)
    {
        $customer->load('addresses');
        if($customer->addresses->count()){
            $customer->addresses->each(function($a){
                $a->is_billing = NULL;
                $a->is_shipping = NULL;
                $a->save();
            });
        }
    }

    private function setAsBilling($customer, $currentAddress)
    {
        $billingAddress = $customer->addresses()->where('is_billing', 1)->get();
        if($billingAddress->count()){
            $billingAddress->each(function($address){
                $address->is_billing = NULL;
                $address->save();
            });
        }
        $currentAddress->is_billing = 1;
        $currentAddress->save();
        return true;
    }

    private function setAsShipping($customer, $currentAddress)
    {
        $shippingAddress = $customer->addresses()->where('is_shipping', 1)->get();
        if($shippingAddress->count()){
            $shippingAddress->each(function($address){
                $address->is_shipping = NULL;
                $address->save();
            });
        }
        $currentAddress->is_shipping = 1;
        $currentAddress->save();
        return true;
    }

    public function makeNew(array $data)
    {
        return static::fill([
                'address_name' => array_key_exists('first_name', $data) ? $data['first_name'] . ' ' . $data['last_name'] : NULL,
                'address_street' => array_key_exists('address_street', $data) ? trim(preg_replace('/\s+/', ' ', $data['address_street']))  : NULL,//remove any new lines 
                'address_street2' => array_key_exists('address_street2', $data) ? $data['address_street2'] : NULL,
                'address_city' => array_key_exists('address_city', $data) ? $data['address_city'] : NULL,
                'address_state' => array_key_exists('address_state', $data) ? $data['address_state'] : NULL,
                'address_zip' => array_key_exists('address_zip', $data) ? $data['address_zip'] : NULL,
                'address_phone' => array_key_exists('contact_phone', $data) ? $data['contact_phone'] : NULL,
                'address_country_code' => array_key_exists('address_country_code', $data) ? $data['address_country_code'] : NULL,
                'address_country_name' => array_key_exists('address_country', $data) ? $data['address_country'] : NULL
            ]);
    }

    public function setAsPrimaryFor(Customer $customer)
    {
        $customer->load('addresses');
        $belongsToCurrent = $customer->addresses->filter(function($a){
            return $a->id == $this->id;
        });
        if($belongsToCurrent->count()){
            $this->resetBillingAndShippingFor($customer);
            $address = $belongsToCurrent->first();
            $address->is_billing = 1;
            $address->is_shipping = 1;
            $address->save();
            return true;
        }
        return false;
    }

    public function setAsBillingFor(Customer $customer)
    {
        $customer->load('addresses');
        $belongsToCurrent = $customer->addresses->filter(function($a){
            return $a->id == $this->id;
        });
        if($belongsToCurrent->count()){
            return $this->setAsBilling($customer, $this);
        }
        return false;
    }

    public function setAsShippingFor(Customer $customer)
    {
        $customer->load('addresses');
        $belongsToCurrent = $customer->addresses->filter(function($a){
            return $a->id == $this->id;
        });
        if($belongsToCurrent->count()){
            return $this->setAsShipping($customer, $this);
        }
        return false;
    }

    public static function deleteAddress($id, Customer $customer)
    {
        $customer->load('addresses');
        if($customer->addresses->count() > 1){
            $currentAddress = $customer->addresses->filter(function($a) use ($id) {
                return $a->id == $id;
            });
            if($currentAddress->count()){
                $currentAddress = $currentAddress->first();
                if($currentAddress->is_billing && $currentAddress->is_shipping){
                     $randomAddress = $customer->addresses->filter(function($a){
                        return $a->is_billing == NULL;
                        });
                     if(!$randomAddress->count()){
                        throw new ModelNotFoundException('Did not find an address to work with.'); 
                     }
                     $randomAddress = $randomAddress->first();
                     $randomAddress->is_billing = 1;
                     $randomAddress->is_shipping = 1;
                     $randomAddress->save();
                     $currentAddress->delete();
                }else if($currentAddress->is_billing && !$currentAddress->is_shipping){
                     $shippingAddress = $customer->addresses->filter(function($a){
                        return $a->is_shipping == 1;
                        });
                     if(!$shippingAddress->count()){
                        throw new ModelNotFoundException('Did not find an address to work with.'); 
                     }
                     $shippingAddress = $shippingAddress->first();
                     $shippingAddress->is_billing = 1;
                     $shippingAddress->save();
                     $currentAddress->delete();
                }else if(!$currentAddress->is_billing && $currentAddress->is_shipping){
                    $billingAddress = $customer->addresses->filter(function($a){
                        return $a->is_billing == 1;
                        });
                    if(!$billingAddress->count()){
                        throw new ModelNotFoundException('Did not find an address to work with.'); 
                     }
                     $billingAddress = $billingAddress->first();
                     $billingAddress->is_shipping = 1;
                     $billingAddress->save();
                     $currentAddress->delete();
                }else if(!$currentAddress->is_billing && !$currentAddress->is_shipping){
                    $currentAddress->delete();
                }
                return true;
            }
            throw new ModelNotFoundException('This address does not belong to user'); 
        }
        return false;         
    }
}

