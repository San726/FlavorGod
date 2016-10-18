<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCreditAdjustmentReason extends Model
{
	use SoftDeletes;

	protected $fillable = ['name', 'description', 'default_operation', 'enabled'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
	];

	public function storeCreditAdjustments()
	{
		return $this->hasMany(StoreCreditAdjustment::class);
	}

}