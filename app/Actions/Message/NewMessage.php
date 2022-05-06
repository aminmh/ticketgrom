<?php

namespace App\Actions\Message;

use App\DataTransferObjects\MessageDTO;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;

class NewMessage
{

    public function __construct(
        private MessageRequest $request
    ) {
    }

    public function sendTo(Ticket|User $contact)
    {
        $data = MessageDTO::fromRequest($this->request);
        $data->message->sender()->associate($data->sender ?? User::find(1));
        $data->message->messageable()->associate($contact);

        return $data->message->save();
    }
}
