<?php

namespace App\Actions\Inbox;

use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;

class CreateInbox
{

    public function __construct(protected Request $request)
    {
    }

    public function create(?\App\Models\Department $department)
    {
        $owner = ($department ?? $this->request->user()) ?? User::find(1);

        $newInbox = new Inbox();
        $newInbox->name = $this->request->name;
        $newInbox->email = $this->request?->email ?? $owner?->email;
        $newInbox->owner()->associate($owner);

        if ($this->request->set_default)
            return $newInbox->saveAsDefault();
        return $newInbox->save();

    }
}
