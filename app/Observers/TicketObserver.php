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
    }

    public function seen(Ticket $ticket)
    {
    }
}
