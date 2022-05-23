<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Notifications\TicketChangedPriorityNotification;
use Illuminate\Support\Facades\Notification;

class TicketObserver
{

    public function updated(Ticket $ticket)
    {

        if ($ticket->wasChanged('priority')) {

            Notification::send(
                notifiables: $ticket
                    ->department()->first()
                    ->members()->get(),
                notification: new TicketChangedPriorityNotification($ticket)
            );
        }

        if ($ticket->wasChanged('department_id'))
            event(new \App\Events\NewTicket($ticket));
    }

    public function responsed(Ticket $ticket)
    {
        $ticket->update([
            'must_close_at' => null
        ]);
    }
}
