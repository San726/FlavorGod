<?php namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DiscountCode extends Model
{
    use SoftDeletes;

    protected $morphClass = 'DiscountCode';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discount_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'enabled'
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
    ];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////

    public function scopeEnabled($query)
    {
        $query->where('enabled', 1)->whereHas('terms', function ($q) {
            $now = Carbon::now();
            $q
            ->where('start_date', '<=', $now->toDateString())
            ->where('end_date', '>=', $now->toDateString());
        });
    }

    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_discount_code', 'discount_code_id', 'cart_id')->withPivot(
            'cart_id',
            'discount_code_id',
            'attributed_at',
            'converted_at',
            'deleted_at',
            'new_referral'
        );
    }

    public function convertedCarts()
    {
        return $this->belongsToMany(Cart::class, 'cart_discount_code', 'discount_code_id', 'cart_id')->whereNotNull('carts.converted_at');
    }

    public function terms()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    public function referrerCustomer()
    {
        return $this->belongsTo(Customer::class, 'referrer_customer_id');
    }

    ///////////////////////////
    //                       //
    //  A T T R I B U T E S  //
    //                       //
    ///////////////////////////
}
