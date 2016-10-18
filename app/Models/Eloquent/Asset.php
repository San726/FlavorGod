<?php

namespace Flavorgod\Models\Eloquent;

use Flavorgod\Models\Eloquent\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\Asset as FitlifeAsset;

class Asset extends FitlifeAsset
{
    protected $morphClass = 'Asset';
    /**
     * Get all of the owning imageable models.
     * @return 
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'assetable');
    }

    /**
     * Get all of the owning imageable models.
     * @return 
     */
    public function productVariants()
    {
        return $this->morphedByMany(ProductVariant::class, 'assetable');
    }

}