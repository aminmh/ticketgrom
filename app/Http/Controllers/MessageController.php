<?php

namespace App\Http\Controllers;

use App\Actions\Message\NewMessage;

class MessageController extends Controller
{
    public function sendToTicket(NewMessage $newMessage, \App\Models\Ticket $ticket)
    {
        try {

            $newMessage->sendTo($ticket);

            return response()->json(json_message('SUCCESS', ['subject' => 'ارسال پیام']));
        } catch (\Throwable $th) {

            return response()->json(json_message('ERROR', ['subject' => 'ارسال پیام']), 500);

            dd($th);
        }
    }

    public function sendToUser(NewMessage $newMessage, \App\Models\User $user)
    {
        try {

            $newMessage->sendTo($user);

            return response()->json(json_message('SUCCESS', ['subject' => 'ارسال پیام']));
        } catch (\Throwable $th) {

            return response()->json(json_message('ERROR', ['subject' => 'ارسال پیام']), 500);

            dd($th);
        }
    }

    public function outbox()
    {
        try {

            $outbox = auth()->user()->messagesOutbox()->get();

            return response()->json(['data' => $outbox]);
        } catch (\Throwable $th) {

        }
    }

    public function inbox()
    {
        try {

            $inbox = (auth()->user() ?? \App\Models\User::find(2))->messages()->get();

            return response()->json(['data' => $inbox]);

        } catch (\Throwable $th) {

            dd($th);
        }
    }
}
