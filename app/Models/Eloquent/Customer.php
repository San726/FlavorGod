<?php namespace Flavorgod\Models\Eloquent;

use Auth;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Flavorgod\Models\Eloquent\traits\CanResetPassword;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Flavorgod\Libraries\ReferralProgram\ReferralProgram;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Customer extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, Authorizable, CanResetPassword;

    protected $morphClass = 'Customer';

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
        'instagram_username',
        'instagram',
        'payer_business_name',
        'payer_email',
        'password',
        'payer_id',
        'payer_status',
        'contact_phone',
        'residence_country',
        'username',
        'verify_token',
        'avatar',
        'oauth_avatar',
        'subscr_id',
        'email',
        'contact_phone',
        'auth_type',
        'verified'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'address_status',
        'payer_business_name',
        'payer_email',
        'payer_id',
        'payer_status',
        // 'contact_phone',
        'residence_country',
        'username',
        'subscr_id',
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that have date types.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Additional attributes to extend the model
     *
     * @var array
     */
    protected $appends = [
        'name',
        'email',
        'phone'
    ];

    /**
     * Return an array with name parts
     * @return array
     */
    public function addressNameLines()
    {
        if($this->address_name){
            $address_name_parts = preg_split('/\s+/', trim($this->address_name));
            return $address_name_parts;
        }
        return [];
    }

    public function withCustomerReferralData()
    {
        $this->load('storeCreditAccount', 'referralDiscountCode');
        $program = new ReferralProgram;
        $this->referrals = $program->setCustomer($this)->getReferrals();
        $this->referrals_earned = $program->getTotalReferralsEarned();
        $this->bonuses_earned = $program->getTotalBonusesEarned();       
        $this->total_referrals_count = $program->getTotalReferralsEarnedCount();
        $this->total_referrals_bonus_count = $program->getTotalBonusesEarnedCount();
        $this->total_gift_cards_count =  $program->getTotalGiftCardsEarned();
        return $this;
    }

    /**
     * Return an array with email parts
     * @return array
     */
    public function emailAddressLines()
    {
        if($this->payer_email){
            $email_parts = explode('@', $this->payer_email);
            return preg_replace('/[^\da-z]/i', '', $email_parts[0]);
        }
        return [];
    }

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

    public function getMemberSinceAttribute()
    {
        $date = Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']));
        return $date->year;
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    public function getAddressAttribute()
    {
        return $this->attributes['address_street'].'\n'.$this->attributes['address_city'].', '.$this->attributes['address_state'].'\n'.$this->attributes['address_country'].'\n'.$this->attributes['address_zip'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['address_name'];
    }

    public function getAvatarAttribute()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->auth_type == 'auth'){
                return $this->attributes['avatar'];
            }else if($user->auth_type == 'oauth'){
                return $this->attributes['oauth_avatar'];
            }
        }else{
            return $this->attributes['avatar'];
        }
    }

    public function setNameAttribute($value)
    {
        return $this->attributes['address_name'] = $value;
    }

    public function getEmailAttribute()
    {
        return $this->attributes['payer_email'];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['payer_email'] = $value;
    }

    public function getPhoneAttribute()
    {
        return isset($this->attributes['contact_phone']) ? $this->attributes['contact_phone'] : null;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['contact_phone'] = $value;
    }

    public function getInstagramAttribute()
    {
        return @$this->attributes['instagram_username'];
    }

    public function setInstagramAttribute($value)
    {
        $this->attributes['instagram_username'] = $value;
    }

    /////////////////////////////////
    //                             //
    //  R E L A T I O N S H I P S  //
    //                             //
    /////////////////////////////////

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function getBillingAddress()
    {
        $this->load(['addresses' => function($address){
            $address->where('is_billing', 1);
        }]);
        if($this->addresses->count()){
            return $this->addresses->first();
        }
    }

    public function getShippingAddress()
    {
        $this->load(['addresses' => function($address){
            $address->where('is_shipping', 1);
        }]);
        if($this->addresses->count()){
            return $this->addresses->first();
        }
    }

    public function storeCreditAccount()
    {
        return $this->hasOne(StoreCreditAccount::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id')->orderBy('created_at', 'desc');
    }

    public function referralDiscountCode()
    {
        return $this->hasOne(DiscountCode::class, 'referrer_customer_id');
    }

    public function storeCreditTransactionsByReferral()
    {
        return $this->hasMany(StoreCreditTransaction::class, 'referred_customer_id', 'id');
    }

     public function customerAddresses()
     {
        return $this->hasMany(CustomerAddress::class);
     }
}
