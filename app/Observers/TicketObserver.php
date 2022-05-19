<?php

namespace App\Observers;

use App\Events\NewTicket;
use App\Events\TicketUpdated;
use App\Infrastructure\Contracts\Repository\UserRepositoryInterface;
use App\Models\Ticket;
use App\Notifications\NewTicketNotification;
use Illuminate\Support\Facades\Notification;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        $department = $ticket->department()->first();

        $userRepository = app(UserRepositoryInterface::class);

        Notification::channel('database')
            ->send($department, (new NewTicketNotification($ticket->replicate(['cc', 'bcc']))));

        $ccMembers = $userRepository->findByEmail($ticket->cc);

        $bccMembers = $userRepository->findByEmail($ticket->bcc);

        $departmentMembers = $department->members()->get();

        Notification::send($ccMembers, new NewTicketNotification($ticket));

        $bccMembers->each(function ($user) use ($ticket) {
            $user
                ->notify((new NewTicketNotification(
                    $ticket
                        ->replicate(['cc'])
                        ->fill([
                            'bcc' => array_filter($ticket->bcc, fn ($email) => $user->email == $email)
                        ])
                ))->onChannels(['']));
        });

        Notification::send($departmentMembers);
    }

    public function updated(Ticket $ticket)
    {
        $orginal = $ticket->getOriginal();

        // if($ticket->wasChanged('status'))

    }

    public function responsed(Ticket $ticket)
    {
        $ticket->update([
            'must_close_at' => null
        ]);
    }

    public function seen(Ticket $ticket)
    {
    }

    private function userRepository(): UserRepositoryInterface
    {
        return app(UserRepositoryInterface::class);
    }
}
