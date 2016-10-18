<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\ProductVariant as FitlifeProductVariant;

class ProductVariant extends FitlifeProductVariant
{
	protected $morphClass = 'ProductVariant';

	protected $appends = [
	    'shippable'
    ];

	public function assets()
    {
        return $this->morphToMany(Asset::class, 'assetable')->withPivot('sort_order', 'relation_type_name')->orderBy('assetables.sort_order', 'ASC');
    }

    public function featuredProducts()
    {
        return $this->morphToMany(FeaturedProduct::class, 'productfeatureable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function featuredProduct()
    {
        return $this->belongsTo(FeaturedProduct::class, 'variant_id', 'id');
    }

    public function children(){
        return $this->belongsToMany(static::class, 'product_variant_product_variant', 'child_id', 'parent_id')->withPivot('quantity');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function getShippableAttribute()
    {
        return !in_array($this->attributes['product_type_id'], [4, 6]);
    }

}