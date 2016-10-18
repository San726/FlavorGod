<?php namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'order_id',
        'product_variant_id',
        'name',
        'sku',
        'item_name',
        'item_number',
        'item_sku',
        'quantity',
        'mc_gross',
        'total',
        'mc_handling',
        'mc_shipping',
        'tax',
        //'free_item',
        //'replacement_item',
        //'athlete_item',
        //'agent_request',
        //'care_package',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'order_id',
        'product_variant_id',
        'mc_handling',
        'mc_shipping',
        'tax',
        'free_item',
        'replacement_item',
        'athlete_item',
        'agent_request',
        'care_package',
        'created_at',
        'updated_at',
        'deleted_at',
        'mc_gross',
        'item_number',
        'item_name'
    ];

    protected $casts = [
        'quantity'  => 'integer',
        'mc_gross'  => 'double',
    ];

    protected $appends = [
        'sku',
        'name',
        'total'
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
    ];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////


    ///////////////////////////
    //                       //
    //  A T T R I B U T E S  //
    //                       //
    ///////////////////////////

    public function getSkuAttribute()
    {
        return $this->attributes['item_number'];
    }

    public function setSkuAttribute($value)
    {
        $this->attributes['item_number'] = $value;
    }

    public function getNameAttribute()
    {
        return $this->attributes['item_name'];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['item_name'] = $value;
    }

    public function getTotalAttribute()
    {
        return isset($this->attributes['mc_gross']) ? (double) $this->attributes['mc_gross']: 0;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['mc_gross'] = $value;
    }

    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}
