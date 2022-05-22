<?php

namespace App\Notifications;

use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketChangedPriorityNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected \App\Models\Ticket $ticket)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $ticket = $this->ticket;

        return [
            "title" => __('messages.TICKET_CHANGED_PRIORITY_TITLE', [], 'fa'),
            "message" => __('messages.TICKET_CHANGED_PRIORITY_MESSAGE', [
                'ID' => $ticket->id,
                'old' => $ticket->getOriginal('priority'),
                'new' => $ticket->priority
            ], 'fa')
        ];
    }
}
