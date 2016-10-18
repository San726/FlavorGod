<?php

namespace Flavorgod\Models\Eloquent;

use Flavorgod\Models\Eloquent\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\ProductCategory as FitlifeProductCategory;

class ProductCategory extends FitlifeProductCategory
{

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_product_category', 'product_category_id', 'product_id');
	}


}