<?php

namespace App\Notifications\CustomChannels;

use Illuminate\Notifications\Notification;

class SMSChannel
{


    public function send(mixed $notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toSMS')) {

        }
    }
}
