<?php

namespace App\Actions\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;

class UpdateTicket
{
    public function __construct(protected Request $request)
    {
    }

    public function update(Ticket $ticket)
    {

    }
}
