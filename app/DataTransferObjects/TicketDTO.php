<?php

namespace App\DataTransferObjects;

use App\Infrastructure\Contracts\DepartmentRepositoryInterface;
use App\Models\Department;
use App\Models\Inbox;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\DataTransferObject\DataTransferObject;


class TicketDTO extends DataTransferObject
{

    public Ticket $ticket;

    public Inbox $inbox;

    public Authenticatable|\App\Models\User $ticketSender;

    public Department $department;

    public static function fromRequest(Request $request)
    {
        return new self([
            'ticket' => new Ticket([
                'text' => $request->text,
                'subject' => $request->subject,
                'status' => $request->status,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'priority' => $request->priority,
                'attached' => $request->hasFile('attached')
                    ? static::saveAttached($request->file('attached'))
                    : null
            ]),
            'inbox' => static::getInbox($request),
            'ticketSender' => $request->user() ?? User::find(1),
            'department' => static::getDepartment($request->department)
        ]);
    }

    protected static function getDepartment($departmentId): Department
    {
        return app(DepartmentRepositoryInterface::class)->find($departmentId);
    }

    protected static function getInbox(Request $request)
    {

        $department = static::getDepartment($request->department);

        $inboxId = $request?->inbox ?? $department->defaultInbox()->inbox_id;

        if ($inboxId)
            return Inbox::find($inboxId);

        throw new ModelNotFoundException(__('messages.NOT_FOUND', ['subject' => 'صندوق دریافتی'], 'fa'));
    }

    private static function saveAttached(UploadedFile $file)
    {
        return Storage::putFileAs('/public/attachments', $file, $file->getClientOriginalName());
    }
}
