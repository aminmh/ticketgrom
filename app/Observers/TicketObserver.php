<?php

namespace App\Observers;

use App\Events\NewTicket;
use App\Events\TicketUpdated;
use App\Models\Ticket;
use App\Notifications\NewTicketNotification;
use Illuminate\Support\Facades\Notification;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        
    }

    public function updated(Ticket $ticket)
    {
        $orginal = $ticket->getOriginal();

        // if($ticket->wasChanged('status'))

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
