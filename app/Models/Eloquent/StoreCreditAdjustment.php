<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCreditAdjustment extends Model
{

	use SoftDeletes;

	protected $fillable = [
        'reason_id', 
        'store_credit_account_id', 
        'note', 
        'action', 
        'amount', 
        'balance_before', 
        'balance_after', 
        'created_by_user_id', 
        'created_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
	];

    public function account()
    {
    	return $this->belongsTo(StoreCreditAccount::class, 'store_credit_account_id', 'id');
    }

    public function reason()
    {
    	return $this->belongsTo(StoreCreditAdjustmentReason::class, 'reason_id', 'id');
    }

 }