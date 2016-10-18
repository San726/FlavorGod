<?php

namespace Flavorgod\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Flavorgod\Models\Eloquent\traits\CanResetPassword;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_city',
        'address_country',
        'address_country_code',
        'address_name',
        'address_state',
        'address_status',
        'address_street',
        'address_zip',
        'first_name',
        'last_name',
        'payer_business_name',
        'payer_email',
        'payer_id',
        'payer_status',
        'contact_phone',
        'residence_country',
        'username',
        'password',
        'avatar',
        'oauth_avatar',
        'subscr_id',
        'remember_token',
        'verified',
        'verify_token',
        'auth_type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Retrieve a Customer by email
     * @param string $email
     * @return static
     */
    public static function byEmail($email)
    {
        return static::where('payer_email', $email)->first();

    }

    /**
     * Retrieve a Customer by verification token
     * @param string $token
     * @return static
     */
    public static function byVerifyToken($token)
    {
        $user = static::where('verify_token', $token)->first();
        if(!$user){
            throw new ModelNotFoundException;
        }
        return $user;
    }

    /**
     * Retrieve a Customer by remember token
     * @param string $token
     * @return static
     */
    public static function byRememberToken($token)
    {
        $user = static::where('remember_token', $token)->first();
        if(!$user){
            throw new ModelNotFoundException;
        }
        return $user; 
    }

    /**
     * A User has a Vip subscription
     * @return Illuminate\Database\Builder
     */
    public function vip()
    {
        return $this->hasOne(VipList::class, 'customer_id');
    }

    /**
     * Determined if user has been subscribed to vip list
     * @return bool
     */
    public function isVip()
    {
        return $this->vip()->count() ? true : false;
    }

    /**
     * Determine if we have an address for this customer
     * @return bool
     */
     public function addressOnFile()
     {
         return $this->getAttribute('address_street') ? $this->getAttribute('address_street') : null;
     }

     /**
      * A user can have many customer addresses
      */
     public function customerAddresses()
     {
        return $this->hasMany(CustomerAddress::class);
     }

}
