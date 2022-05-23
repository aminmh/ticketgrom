<?php

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('department.{department}.tickets', function ($user, Department $department) {
    return Auth::check();
});

Broadcast::channel('department.{department}.ticket.updates', function ($user, Department $department) {
    return Auth::check() && in_array(Auth::user()->id, $department->members()->get()->pluck('id')->toArray());
});

Broadcast::channel('message.for.me.{userId}', function ($user, int $userId) {
    return Auth::check() && Auth::id() === $userId;
});
