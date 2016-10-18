<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class VipList extends Model
{
    protected $table = 'viplist';

    /**
     * The fields that can be mass assigned
     * @return array $fillable
     */
    protected $fillable = ['customer_id','active', 'first_name', 'last_name', 'email'];

    /**
     * A viplist item belongs to a user
     * @return Illuminate\Database\Builder
     */
    public function user()
    {
    	return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * A viplist model has many out of stock notices
     */
    public function outOfStock()
    {
        return $this->hasMany(\Flavorgod\Models\Eloquent\OutOfStock::class, 'viplist_id');
    }
}
