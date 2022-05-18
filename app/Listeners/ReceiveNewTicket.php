<?php

namespace App\Listeners;

use App\Infrastructure\Contracts\Repository\UserRepositoryInterface;
use App\Notifications\NewTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use PhpParser\Node\Expr\New_;

class ReceiveNewTicket
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewTicket  $event
     * @return void
     */
    public function handle(\App\Events\NewTicket $event)
    {
        $ticket = $event->ticket;

        $department = $ticket->department()->first();

        Notification::channel('database')
            ->send($department, (new NewTicketNotification($ticket->replicate(['cc', 'bcc']))));

        // $department->notify(
        //     (new NewTicketNotification($ticket->replicate(['cc', 'bcc'])))
        //         ->onChannels('database')
        // );

        $ccMembers = $this->userRepository()->findByEmail($ticket->cc);

        Notification::send($ccMembers, new NewTicketNotification($ticket));

        $bccMembers = $this->userRepository()->findByEmail($ticket->bcc);

        collect($bccMembers)->each(function (\App\Models\User $user) use ($ticket) {
            $user
                ->notify((new NewTicketNotification(
                    $ticket
                        ->replicate(['cc'])
                        ->fill([
                            'bcc' => array_filter($ticket->bcc, fn ($email) => $user->email == $email)
                        ])
                ))->onChannels(['']));
        });

        $departmentMembers = $department->members()->get();

        Notification::send($departmentMembers);
    }

    public function userRepository(): UserRepositoryInterface
    {
        return app(UserRepositoryInterface::class);
    }
}
