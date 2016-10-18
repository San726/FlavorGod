<?php namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    protected $morphClass = 'Discount';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'max_use',
        'min_amount',
        'min_quantity',
        'combinable',
        'enabled',
        'amount',
        'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that have date types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'value' => 'double',
        'min_amount' => 'double',
        'max_amount' => 'double',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
        'combinable' => 'boolean'
    ];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////

    public function scopeCombinable($query)
    {
        $query->where('combinable', 1);
    }

    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function codes()
    {
        return $this->hasMany(DiscountCode::class, 'discount_id', 'id');
    }

    ///////////////////////////
    //                       //
    //  A T T R I B U T E S  //
    //                       //
    ///////////////////////////

    public function setTypeAttribute($val)
    {
        $this->attributes['type'] = $val ? 1 : 0;
    }

}
