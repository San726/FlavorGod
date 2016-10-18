<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
	use SoftDeletes;

	const STATUS_OPEN       = 0x0000;
	const STATUS_PENDING    = 0x0001;
	const STATUS_CLOSED     = 0x0002;

	protected $morphClass = 'Cart';

	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carts';

	/**
	 * The attributes that are mass assignable
	 *
	 * @var array
	 */
	protected $fillable = [
		'sid',
		'transaction_id',
		'transaction_ref',
		'contact_firstname',
		'contact_lastname',
		'contact_email',
		'contact_phone',
		'contact_handle',
		'billing_firstname',
		'billing_lastname',
		'billing_address',
		'billing_address2',
		'billing_city',
		'billing_state',
		'billing_zip',
		'billing_country',
		'shipping_firstname',
		'shipping_lastname',
		'shipping_address',
		'shipping_address2',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'shipping_country',
		'tax_rate',
		'shipping_fee',
		'handling_fee',
		'currency',
		'order_id'
	];

	protected $hidden = [
	    // 'id',
	    'sid',
	    'converted_at',
	    'created_at',
	    'updated_at',
	    'deleted_at'
    ];

    protected $appends = [
		//
		'status'
    ];

    protected $dates = [
        'converted_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
    	'shipping_fee' => 'double',
    	'handling_fee' => 'double'
    ];

	/////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function storeCredits()
    {
        return $this->belongsToMany(StoreCreditAccount::class, 'cart_store_credit', 'cart_id', 'store_credit_id')
        ->withPivot('cart_id', 'store_credit_id', 'amount_applied', 'deleted_at')
        ->withTimeStamps();
    }

    public function items()
    {
    	return $this->hasMany(CartItem::class, 'cart_id', 'id')->orderBy('cart_items.id', 'desc');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function discounts()
    {
        return $this
        ->belongsToMany(DiscountCode::class, 'cart_discount_code', 'cart_id', 'discount_code_id')
        ->withPivot('id as cart_discount_code_id', 'deleted_at', 'attributed_at')
        ->whereNull('cart_discount_code.deleted_at');
    }

     public function recoveredCarts()
    {
    	return $this->hasMany(RecoveredCart::class);
    }

    public function failedAttempts()
    {
    	return $this->hasMany(CartFailedAttempt::class, 'cart_id', 'id');
    }

    public function uniqueFailedAttempts()
    {
    	return $this->hasMany(CartFailedAttempt::class, 'cart_id', 'id')->groupBy('card_last_four');
    }

    //  A T T R I B U T E S

    public function getStatusAttribute() {
    	$attr = $this->attributes;

    	switch (true) {
    		case (empty($attr['transaction_id'])):
    			return static::STATUS_OPEN;
    		case (empty($attr['converted_at'])):
    			return static::STATUS_PENDING;
    		default:
    			return static::STATUS_CLOSED;
    	}
    }

}