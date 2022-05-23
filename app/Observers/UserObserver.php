<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\AccountSuspendedNotification;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    public function updated()
    {
    }

    public function suspended(User $user)
    {
        $user->update([
            'suspended' => true
        ]);

        Notification::send($user, new AccountSuspendedNotification($user));
    }
}
