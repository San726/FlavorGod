<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zipcode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zipcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'position',
        'locationlinkkey',
        'locationname',
        'paypalemail',
        'bgsaccountmanager',
        'product_set_id',
        'product_price_id',
        'free_product_tier_set_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////

    public function scopeEnabledOnly($query) {
        return $query->where('decommissioned', 0);
    }
}
