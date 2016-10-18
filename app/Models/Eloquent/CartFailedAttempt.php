<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartFailedAttempt extends Model
{

	const TXN_TYPE_CREDITCARD   = 'credit_card';
	const TXN_TYPE_PAYPAL       = 'paypal';


    /**
     * The name used to distinguish this morphed model
     *
     * @var string
     */
    protected $morphClass = 'CartFailedAttempt';

	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cart_failed_attempts';

	/**
	 * The attributes that are mass assignable
	 *
	 * @var array
	 */
	protected $fillable = [
		'cart_id',
        'ip',
		'user_agent',
		'txn_type',
		'card_type',
		'card_last_four',
		'cvv_code',
		'avs_street_code',
		'avs_postal_code',
		'processor_code',
		'amount',
		'failed_message'
	];

	protected $hidden = [];

    protected $appends = [
        'transaction_type'
    ];

    protected $dates = [
        'failed_at'
    ];

    protected $casts = [
        'amount' => 'double'
    ];

    public $timestamps = false;

	/////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    ///////////////////////////
    //                       //
    //  A T T R I B U T E S  //
    //                       //
    ///////////////////////////

    public function getTransactionTypeAttribute()
    {
        return $this->attributes['txn_type'];
    }

    public function setTransactionTypeAttribute($value)
    {
        $this->attributes['txn_type'] = $value;
    }

}