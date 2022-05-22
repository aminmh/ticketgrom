<?php

namespace App\Actions\Ticket;

use App\Events\TicketUpdated;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UpdateTicket
{
    const UPDATEABLES = ['status', 'department_id'];

    public function __construct(protected Request $request)
    {
    }

    public function __invoke(Ticket $ticket)
    {
        $request = $this->request->all();

        $modified = array_reduce(
            self::UPDATEABLES,
            function ($preProp, $currProp) use ($ticket, $request) {

                $ticket->{$currProp} = $request[$currProp];

                return $ticket;
            }
        );

        $modified->save();
    }
}
