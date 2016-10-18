<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';

    protected $dates = [
        'created_at',
        'deleted_at'
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_type_id', 'id');
    }

}