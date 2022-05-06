<?php


namespace App\DataTransferObjects;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class MessageDTO extends DataTransferObject
{

    public \App\Models\Message $message;

    public Authenticatable|\App\Models\User|null $sender;

    public static function fromRequest(Request $request)
    {
        return new self([
            'message' => new \App\Models\Message([
                'message' => $request->message,
                'status_id' => $request->status,
            ]),
            'sender' => auth()->user()
        ]);
    }
}
