<?php namespace Flavorgod\Models\Eloquent;

use Flavorgod\Models\Eloquent\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $morphClass = 'Note';

    protected $table = 'notes';

    protected $fillable = [
        'notable_type', // Order, Product, etc.
        'notable_id', //
        'notable_status_id', // If item has a status, record it here (just orders?)
        'note',
        'notable_source_type', //User, Customer, Agent, IpnOrder, OrderShipment, etc.
        'notable_source_id', //
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function notable()
    {
        return $this->morphTo('notable');
    }

    public function notableSource()
    {
        return $this->morphTo('notable_source');
    }
}
