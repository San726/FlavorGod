<?php

namespace Flavorgod\Listeners;

use Mail;
use Flavorgod\Events\TransactionBonusEarned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailTransactionBonus
{
    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(TransactionBonusEarned $event)
    {
        $customer = $event->customer;
        $email = $customer->payer_email;
        Mail::send('emails.referralprogram.transactionbonus', compact('customer'), function($m) use ($email){
                $m->to($email)->subject('Transaction Bonus');
        }); 
    }
}