<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class OutOfStock extends Model
{
	/**
	 * The table being used by the this model
	 */
	protected $table= "out_of_stock";
	/**
	 * The fields that can be mass assigned
	 */
	protected $fillable = [
		'viplist_id',
		'variant_sku',
		'product_url'
	];

	/**
	 * The outofstock model belongs to a vipmodel
	 */
	public function vipList()
	{
		return $this->belongsTo(\Flavorgod\Models\Eloquent\VipList::class);
	}
}