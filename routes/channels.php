<?php

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

Broadcast::channel('tickets.inbox.{inboxId}', function ($user, int $inboxId) {
    return Auth::check() && in_array($inboxId, Auth::user()->inboxes()->get()->pluck('id'));
});

Broadcast::channel('message.for.me.{userId}', function ($user, int $userId) {
    return Auth::check() && Auth::id() === $userId;
});
