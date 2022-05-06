<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Actions\Ticket\CreateNewTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    public function store(CreateNewTicket $createNewTicket)
    {
        try {

            $createNewTicket->send();
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function markAsFavorite(Ticket $ticket)
    {
        try {

            $ticket->markAsFavorite();
        } catch (\Throwable $th) {

            dd($th);
        }
    }

    public function favorites()
    {
        try {

            $favorites = (new Ticket)->whereHas('favorites')->get();

            return response()->json(['data' => $favorites]);
        } catch (\Throwable $th) {

            dd($th);
        }
    }

    public function outbox()
    {
        try {

            $outbox = auth()->user()->tickets()->get();

            return response()->json(['data' => $outbox]);

        } catch (\Throwable $th) {

            dd($th);
        }
    }
}
