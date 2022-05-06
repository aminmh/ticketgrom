<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification
{
    // use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Ticket $ticket
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable instanceof \App\Models\User
            ? ['mail', 'broadcast']
            : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Mail\Mailable
     */
    public function toMail($notifiable)
    {
        return (new \App\Mail\HaveNewTicket($this->ticket))
            ->send($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->ticket->toArray()
        ];
    }

    public function broadcastOn()
    {
        return [new PrivateChannel("tickets.inbox." . $this->ticket->inbox_id)];
    }

    public function broadcastType()
    {
        return "broadcast.ticket";
    }
}
