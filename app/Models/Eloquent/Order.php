<?php namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_AWAITING_PAYMENT    = 1;
    const STATUS_PROCESSING          = 2;
    const STATUS_AWAITING_SHIPMENT   = 3;
    const STATUS_SHIPPED             = 4;
    const STATUS_DELIVERED           = 5;
    const STATUS_CANCELLED           = 6;
    const STATUS_ON_HOLD             = 7;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $morphClass = 'Order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'external_order_id',
        //'whs_order_id',
        'txn_id',
        'customer_id',
        //'payment_status_id',
        //'fulfillment_status_id',
        //'fulfillment_status_note',
        //'fulfilled_at',
        //'shipment_status_id',
        //'order_status_id',
        //'agent_id',
        //'store_id',
        //'parent_order_id',
        'custom',
        'memo',
        'tax',
        'payment_date',
        'shipping_method',
        // 'shipping',
        'shipping_priority',
        'exchange_rate',
        'mc_currency',
        'mc_fee',
        'mc_gross',
        'mc_discount',
        'mc_handling',
        'mc_shipping',
        'address_name',
        'address_email',
        'address_company',
        'address_street',
        'address_city',
        'address_state',
        'address_country_code',
        'address_zip',
        'address_phone',
        'currency',
        'transaction_fee',
        'shipping_fee',
        'handling_fee',
        'total',
        'discount_total',
        //'fulfillment_provider_id',
        //'fulfillment_provider_order_id',
        //'confirmed_at',
        //'agentupdated_at',
        'transaction_id',
        'external_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
        'external_order_id',
        'whs_order_id',
        'txn_id',
        'customer_id',
        'payment_status_id',
        'fulfillment_status_id',
        'fulfillment_status_note',
        'fulfilled_at',
        'shipment_status_id',
        'order_status_id',
        'agent_id',
        'store_id',
        'parent_order_id',
        'custom',
        'payment_date',
        'shipping_method',
        'shipping_priority',
        'exchange_rate',
        'fulfillment_provider_id',
        'fulfillment_provider_order_id',
        'confirmed_at',
        'agentupdated_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'confirmed',
        'mc_currency',
        'mc_fee',
        'address_name',
        'address_email',
        'address_company',
        'address_street',
        'address_city',
        'address_state',
        'address_country_code',
        'address_zip',
        'address_phone'
    ];

    /**
     * The attributes that have date types.
     *
     * @var array
     */
    protected $dates = [
        'fulfilled_at',
        'confirmed_at',
        'agentupdated_at',
    ];

    protected $appends = [
        'date',
        'currency',
        'external_id',
        'shipping_fee',
        'handling_fee',
        'transaction_fee',
        'total',
        'confirmed'
    ];

    protected $casts = [
        'tax'   => 'double'
    ];

    ///////////////////
    //               //
    //  S C O P E S  //
    //               //
    ///////////////////

    public function scropeOriginal($query)
    {
        $query->where('parent_order_id', 0)->orWhere('parent_order_id', null);
    }

    ///////////////////////////
    //                       //
    //  A T T R I B U T E S  //
    //                       //
    ///////////////////////////

    public function getDateAttribute()
    {
        return $this->attributes['created_at'];
    }

    public function getOrderStatusOrderLabelAttribute()
    {
        $this->load('orderStatus');
        switch ($this->orderStatus->name) {
            case 'Processing':
                return 'pending';
                break;
            case 'Shipped':
                return 'shipped';
                break;
            case 'Delivered':
                return 'shipped';
                break;
            case 'Cancelled':
                return 'cancelled';
                break;
            default:
                return 'pending';
                break;
        }
    }

    public function getDateOfPurchaseAttribute()
    {
       $date = Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']));
        return $date->format('m/d/Y');
    }

    public function getItemsCountAttribute()
    {
        $this->load('items');
        $amount = 0;
        $this->items->each(function($item) use (&$amount) {
            $amount += $item->quantity;
        });
        return $amount;
    }

    public function getTotalGrossAttribute()
    {
        return $this->attributes['mc_gross'] - $this->attributes['mc_discount'] - $this->attributes['mc_store_credit'];
    }   

    public function getCurrencyAttribute()
    {
        return $this->attributes['mc_currency'];
    }

    public function setCurrencyAttribute($value)
    {
        $this->attributes['mc_currency'] = $value;
    }

    public function getShippingFeeAttribute()
    {
        return (double) $this->attributes['mc_shipping'];
    }

    public function setShippingFeeAttribute($value)
    {
        $this->attributes['mc_shipping'] = $value;
    }

    public function getHandlingFeeAttribute()
    {
        return (double) $this->attributes['mc_handling'];
    }

    public function setHandlingFeeAttribute($value)
    {
        $this->attributes['mc_handling'] = $value;
    }

    public function getTransactionFeeAttribute()
    {
        return (double) $this->attributes['mc_fee'];
    }

    public function setTransactionFeeAttribute($value)
    {
        $this->attributes['mc_fee'] = $value;
    }

    public function getTotalAttribute()
    {
        return (double) $this->attributes['mc_gross'];
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['mc_gross'] = $value;
    }

    public function getConfirmedAttribute()
    {
        return (bool) isset($this->attributes['confirmed_at']);
    }

    public function setConfirmedAttribute($value)
    {
        $this->attributes['confirmed_at'] = new Carbon;
    }

    public function getTransactionIdAttribute()
    {
        return $this->attributes['txn_id'];
    }

    public function setTransactionIdAttribute($value)
    {
        $this->attributes['txn_id'] = $value;
    }

    public function getExternalIdAttribute()
    {
        return $this->attributes['external_order_id'];
    }

    public function setExternalIdAttribute($value)
    {
        $this->attributes['external_order_id'] = $value;
    }

    public function getDiscountTotalAttribute()
    {
        return (double) $this->attributes['mc_discount'] ?: 0.00;
    }

    public function setDiscountTotalAttribute($value)
    {
        $this->attributes['mc_discount'] = $value;
    }

    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function duplicates()
    {
        return $this->hasMany(Order::class, 'parent_order_id', 'id');
    }

    public function original()
    {
        return $this->belongsTo(Order::class, 'parent_order_id', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'store_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, "notable");
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
