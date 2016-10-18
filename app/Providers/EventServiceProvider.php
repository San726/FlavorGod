<?php

namespace Flavorgod\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Flavorgod\Events\GiftCardBonusEarned' => [
            'Flavorgod\Listeners\EmailGiftCardBonus',
        ],
        'Flavorgod\Events\TransactionBonusEarned' => [
            'Flavorgod\Listeners\EmailTransactionBonus',
        ],
        'Flavorgod\Events\StoreCreditBonusEarned' => [
            'Flavorgod\Listeners\EmailStoreCreditBonus',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
