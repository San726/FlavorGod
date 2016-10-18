<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ProductSearch extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_search';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'raw_search',
        'keywords',
        'results_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that have date types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////


    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

}
