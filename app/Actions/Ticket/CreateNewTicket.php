<?php

namespace App\Actions\Ticket;

use App\DataTransferObjects\TicketDTO;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Storage;

class CreateNewTicket
{

    public function __construct(
        private TicketRequest $request
    ) {
    }

    public function send()
    {
        try {
            $data = TicketDTO::fromRequest($this->request);

            $data->ticket->sender()->associate($data->ticketSender);
            $data->ticket->department()->associate($data->department);
            $data->ticket->inbox()->associate($data->inbox);

            $data->ticket->save();
            
        } catch (\Throwable $th) {

            Storage::delete($data->ticket->attached);

            throw $th;
        }
    }
}
