<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecoveredCart extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'cart_id',
		'parent_sid',
		'new_sid',
		'converted',
		'reference'
	];

	public function cart()
	{
		return $this->belongsTo(Cart::class);
	}

}