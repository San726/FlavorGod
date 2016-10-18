<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProduct extends Model
{

	protected $morphClass = 'FeaturedProduct';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'variant_sku', 'variant_id', 'description'];

    /**
	 * A Featured product may belong to many Products
	 */
	public function products()
	{
		return $this->morphedByMany(Product::class, 'productfeatureable');
	}

	/**
	 * A Featured product may belong to many ProductVariants
	 */
	public function productVariants()
	{
		return $this->morphedByMany(ProductVariant::class, 'productfeatureable');
	}

	/**
	 * A Featured Product has one ProductVariant
	 */
	public function ProductVariant()
	{
		return $this->hasOne(ProductVariant::class, 'id', 'variant_id');
	}


}