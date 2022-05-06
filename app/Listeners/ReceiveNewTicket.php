<?php

namespace App\Listeners;

use App\Notifications\NewTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ReceiveNewTicket
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
     * @param  \App\Events\NewTicket  $event
     * @return void
     */
    public function handle(\App\Events\NewTicket $event)
    {
        $notification = new NewTicketNotification($event->ticket);

        $department = $event->ticket->department()->first();

        $department->notify($notification);

        Notification::send($department->members()->get(), $notification);
    }
}
