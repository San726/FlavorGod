<?php

namespace Flavorgod\Events;

use Flavorgod\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TransactionBonusEarned extends Event
{
    use SerializesModels;

    public $customer;

     /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }
}