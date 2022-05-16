<?php

namespace App\Observers;

use App\Events\NewTicket;
use App\Events\TicketUpdated;
use App\Infrastructure\Contracts\Repository\DepartmentRepositoryInterface;
use App\Models\Ticket;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        event(new NewTicket($ticket));
    }

    public function updated(Ticket $ticket)
    {
        event(new TicketUpdated($ticket));
    }

    public function responsed(Ticket $ticket)
    {
        $ticket->withoutEvents(
            fn () => $ticket->update([
                'must_close_at' => null
            ])
        );
    }

    public function seen(Ticket $ticket)
    {
    }
}
