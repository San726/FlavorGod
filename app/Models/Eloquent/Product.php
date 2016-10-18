<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\Product as FitlifeProduct;

class Product extends FitlifeProduct
{
	protected $morphClass = 'Product';

    public $assetTypes = [];

	public function assets()
    {
        return $this->morphToMany(Asset::class, 'assetable')->withPivot('sort_order', 'relation_type_name')->orderBy('assetables.sort_order', 'ASC');
    }

    public function featuredProducts()
    {
        return $this->morphToMany(FeaturedProduct::class, 'productfeatureable');
    }

    public function variants()
    {
    	return $this->hasMany(ProductVariant::class, 'product_id', 'id')->where('product_variants.enabled', 1)->orderByRaw('IF(product_variants.sort_order IS NULL,1,0) asc, product_variants.sort_order asc, id asc');
    }

    public function variantsAll()
    {
    	return $this->hasMany(ProductVariant::class, 'product_id', 'id')->orderByRaw('IF(product_variants.sort_order IS NULL,1,0) asc, product_variants.sort_order asc, id asc');;
    }

    public function baseVariant()
   {
       if (isset($this->pivot) && !empty($this->pivot->base_variant_id)) {
           return $this->hasOne(ProductVariant::class, 'product_id', 'id')
           ->where('product_variants.enabled', 1)
           ->orderByRaw('IF(product_variants.id = ' . $this->pivot->base_variant_id . ', 0, 1) asc, IF(product_variants.sort_order IS NULL,1,0) desc, product_variants.sort_order desc, id desc');
        //   ->where('id', (int) $this->pivot->base_variant_id);
       }

       return $this->hasOne(ProductVariant::class, 'product_id', 'id')->where('product_variants.enabled', 1)->orderByRaw('IF(product_variants.sort_order IS NULL,1,0) asc, product_variants.sort_order asc, id asc');
   }

    public function productSets()
    {
        return $this->belongsToMany(ProductSet::class, 'product_product_set', 'product_id', 'product_set_id')->withPivot('sort_order', 'base_variant_id');
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(ProductSet::class, 'product_product_set', 'product_id', 'product_set_id')->where('product_set_id', 2);
    // }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id');
    }


}