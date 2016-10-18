<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductSetType extends Model
{
    use SoftDeletes;

    protected $table = 'product_set_types';

    protected $dates = [
        'created_at',
        'deleted_at'
    ];

    public function productSets()
    {
        return $this->hasMany(ProductSet::class, 'product_set_type_id', 'id');
    }

}