<?php

namespace App\Http\Controllers;

use App\Actions\Inbox\CreateInbox;

class InboxController extends Controller
{
    public function store(CreateInbox $createInbox, ?\App\Models\Department $department = null)
    {
        try {
            $createInbox->create($department);

            return response()->json(json_message('SUCCESS'));
        } catch (\Throwable $th) {

            dd($th->getMessage());
        }
    }

    public function show(?\App\Models\Inbox $inbox = null)
    {
        try {

            $userInbox = $inbox ?? auth()->user()->inboxes();

            return response()->json([
                'data' => $userInbox->with(['tickets' => function ($query) {
                    return $query->with('responses');
                }])
            ]);
        } catch (\Throwable $th) {

            dd($th);
        }
    }

    public function destroy(\App\Models\Inbox $inbox)
    {
        try {

            $tickets = $inbox->tickets()->get()->pluck('id');

            \App\Models\Ticket::destroy($tickets);

            $inbox->delete();

            return response()->json(json_message('SUCCESS'));

        } catch (\Throwable $th) {

            dd($th);
        }
    }
}
