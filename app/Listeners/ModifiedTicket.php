<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModifiedTicket
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
     * @param  \App\Events\TicketUpdated  $event
     * @return void
     */
    public function handle(\App\Events\TicketUpdated $event)
    {
        // $event->ticket
    }
}
