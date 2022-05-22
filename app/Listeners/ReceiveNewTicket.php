<?php

namespace App\Listeners;

use App\Infrastructure\Contracts\Repository\UserRepositoryInterface;
use App\Notifications\NewTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification as NotificationFacades;

class ReceiveNewTicket
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
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

        $ccMembers = $this->userRepository->findByEmail($ticket->cc);

        $bccMembers = $this->userRepository->findByEmail($ticket->bcc);

        $this->notify(
            notifiable: $department,
            notification: new NewTicketNotification($ticket->replicate(['cc', 'bcc'])),
            channel: 'database'
        );

        $this->notify(
            notifiable: $ccMembers,
            notification: new NewTicketNotification($ticket),
            channel: 'mail'
        );

        $this->notify(
            notifiable: $department->members()->get(),
            notification: new NewTicketNotification($ticket)
        );

        $bccMembers->each(fn ($user) => $this
            ->notify(
                notifiable: $user,
                notification: new NewTicketNotification($ticket->replicate(['cc'])->fill([
                    'bcc' => array_filter(
                        array: array_unique($ticket->bcc),
                        callback: fn ($email) => $user->email == $email
                    )

                ])),
                channel: 'mail'
            ));
    }

    private function notify($notifiable, Notification $notification, ?string $channel = null)
    {
        if ($channel)
            return NotificationFacades::channel($channel)->send($notifiable, $notification);

        return NotificationFacades::send($notifiable, $notification);
    }
}
