<?php

namespace App\Notifications;

use App\Notifications\CustomChannels\SMSChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    // use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected \App\Models\Message $message)
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
        return $notifiable instanceof \App\Models\User
        ? ['broadcast'] :
            [/*, 'database', SMSChannel::class*/];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->view(
                view: 'mail.message_notification',
                data: [
                    'message' => $this->message,
                    'from' => $this->message->sender()
                ]
            );
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
            'message' => $this->message->toArray()
        ];
    }

    public function broadcastOn()
    {
        return [new PrivateChannel("message.for.me." . $this->message->messageable()->first()->id)];
    }

    public function broadcastType()
    {
        return "broadcast.message";
    }
}
