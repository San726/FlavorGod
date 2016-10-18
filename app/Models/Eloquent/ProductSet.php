<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\ProductSet as FitlifeProductSet;

class ProductSet extends FitlifeProductSet
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_product_set', 'product_set_id', 'product_id')->withPivot('sort_order', 'base_variant_id')->orderBy('pivot_sort_order');
    }

    public function type()
    {
        return $this->belongsTo(ProductSetType::class, 'product_set_type_id', 'id');
    }
}