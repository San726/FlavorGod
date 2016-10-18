<?php

namespace Flavorgod\Listeners;

use Mail;
use Flavorgod\Events\StoreCreditBonusEarned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailStoreCreditBonus
{
    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(StoreCreditBonusEarned $event)
    {
        $customer = $event->customer;
        $email = $customer->payer_email;
        Mail::send('emails.referralprogram.storecreditbonus', compact('customer'), function($m) use ($email){
                $m->to($email)->subject('Store credit bonus');
        }); 
    }   
}