<?php

namespace App\Observers;

use App\Events\NewTicket;
use App\Models\Ticket;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        event(new NewTicket($ticket));
    }

    public function responsed(Ticket $ticket)
    {
        $ticket->update([
            'must_close_at' => null
        ]);
    }

    public function seen(Ticket $ticket)
    {
    }
}
