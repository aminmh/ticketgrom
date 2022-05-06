<?php

namespace App\Listeners;

use App\Notifications\NewMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ReceiveNewMessage
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
     * @param  \App\Events\NewMessage  $event
     * @return void
     */
    public function handle(\App\Events\NewMessage $event)
    {
        $message = $event->message;
        
        Notification::send($message->messageable()->first(), new NewMessageNotification($message));
    }
}
