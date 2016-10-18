<?php

namespace Flavorgod\Listeners;

use Mail;
use Flavorgod\Events\GiftCardBonusEarned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailGiftCardBonus
{
    protected $addressesToSendTo = ['yogi@shredz.com'];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(GiftCardBonusEarned $event)
    {
        $customer = $event->customer;
        foreach ($this->addressesToSendTo as $address) {
            Mail::send('emails.referralprogram.giftcardemail', compact('customer'), function($m) use ($address){
                $m->to($address)->subject('Gift card bonus alert');
            }); 
        }
    }
}
