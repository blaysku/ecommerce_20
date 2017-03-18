<?php

namespace App\Listeners;

use App\Events\UserAccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Locale;

class UserAccess
{
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
     * @param  UserAccessEvent  $event
     * @return void
     */
    public function handle(UserAccessEvent $event)
    {
        Locale::setLocale();
    }
}
