<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCreditAccount extends Model
{

	use SoftDeletes;

	protected $fillable = [
        'customer_id', 
        'balance',
        'code',//use this code for gift cards
        'balance'
    ];

	    protected $dates = [
	        'created_at',
	        'updated_at',
	        'deleted_at'
    	];

   	/////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////
    /**
     * Get the user who owns the account
     */
    public function user()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_store_credit', 'store_credit_id', 'cart_id')->wherePivot('deleted_at', NULL);
    }

    public function storeCreditAdjustments()
    {
        return $this->hasMany(StoreCreditAdjustment::class);
    }

    public function getBalanceAttribute()
    {
        return number_format($this->attributes['balance'], 2);
    }
}