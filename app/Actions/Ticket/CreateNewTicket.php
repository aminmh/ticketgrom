<?php

namespace App\Actions\Ticket;

use App\DataTransferObjects\TicketDTO;
use App\Http\Requests\TicketRequest;
use App\Infrastructure\Traits\HasBcc;
use App\Models\Ticket;

class CreateNewTicket
{

    use HasBcc;

    public function __construct(
        private TicketRequest $request
    ) {
    }

    public function send()
    {
        $data = TicketDTO::fromRequest($this->request);

        $data->ticket->sender()->associate($data->ticketSender);
        $data->ticket->department()->associate($data->department);
        $data->ticket->inbox()->associate($data->inbox);

        $data->ticket->save();
    }

    private function notifyToDepartmentMembers($members, Ticket $ticket)
    {

        \Illuminate\Support\Facades\Notification::send($members, '');
    }
}
