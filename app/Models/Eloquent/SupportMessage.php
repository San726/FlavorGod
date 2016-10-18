<?php

namespace Flavorgod\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SupportMessage extends Model
{

   protected $fillable = [
       'enquiry_type',
       'email',
       'first_name',
       'last_name',
       'message'
       ];


}