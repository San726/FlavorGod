<?php

namespace Flavorgod\Models\Eloquent;

use FitlifeGroup\Models\Eloquent\Channel as BaseModel;

class Channel extends BaseModel
{
    protected $morphClass = 'Store';

    public function assets()
    {
        return $this->morphToMany(Asset::class, 'assetable')->withPivot('sort_order', 'relation_type_name')->orderBy('assetables.sort_order', 'ASC');
    }
}
