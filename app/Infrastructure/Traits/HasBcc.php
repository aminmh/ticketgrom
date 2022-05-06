<?php

namespace App\Infrastructure\Traits;

use App\Models\Ticket;

trait HasBcc
{

    public function resolveBcc(Ticket $ticket, string $userEmail): Ticket
    {

        return $ticket
            ->replicate()->fill(array_merge($ticket->toArray(), [
                'cc' => [],
                'bcc' => array_filter($ticket->bcc, fn ($email) => $email === $userEmail)
            ]));

    }

    public function ticketHasBcc(Ticket $ticket): bool
    {
        return (bool) count($ticket->bcc) ?? false;
    }
}
