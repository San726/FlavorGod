<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\Store as FitlifeStore;

class Store extends FitlifeStore
{
    protected $morphClass = 'Store';
    public $assetTypes = [];
    public function assets()
    {
        return $this->morphToMany(Asset::class, 'assetable')->withPivot('sort_order', 'relation_type_name')->orderBy('assetables.sort_order', 'ASC');
    }
}