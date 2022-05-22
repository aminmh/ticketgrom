<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\callback;

class NewTicketNotification extends Notification
{
    // use Queueable;

    protected array $channels = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Ticket $data
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
        return ['mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Mail\Mailable
     */
    public function toMail($notifiable)
    {
        $ticket = $this->data;

        return (new \App\Mail\HaveNewTicket($ticket))
            ->cc($ticket->cc)
            ->bcc($ticket->bcc)
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
        $ticket = $this->data;

        return [
            'text' => $ticket->text,
            'subject' => $ticket->subject,
            'status' => $ticket->status()->first()->status,
            'priority' => $ticket->priority
        ];
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel("tickets.inbox." . $this->data->inbox_id)
        ];
    }

    public function broadcastType()
    {
        return "broadcast.ticket";
    }

    public function onChannels(array|string $channels)
    {
        $this->channels = Arr::wrap($channels);

        return $this;
    }
}
