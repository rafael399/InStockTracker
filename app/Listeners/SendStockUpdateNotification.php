<?php

namespace App\Listeners;

use App\Events\NowInStock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;

class SendStockUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NowInStock  $event
     * @return void
     */
    public function handle(NowInStock $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
