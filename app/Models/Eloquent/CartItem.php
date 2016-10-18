<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use FitlifeGroup\Models\Eloquent\Channel;
use FitlifeGroup\Models\Eloquent\Agent;

class CartItem extends Model
{

	use SoftDeletes;

	protected $morphClass = 'CartItem';

	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
	 * The attributes that are mass assignable
	 *
	 * @var array
	 */
	protected $fillable = [
		'sku',
		'quantity',
		'channel_id',
		'agent_id',
	];

	protected $hidden = [
	    'id',
	    'cart_id',
	    'created_at',
	    'updated_at',
	    'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'double'
    ];


	/////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function cart()
    {
    	return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function product() {
        return $this->belongsTo(ProductVariant::class, 'sku', 'sku');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'channel_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

}