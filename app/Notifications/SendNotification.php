<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SendNotification extends Notification implements ShouldBroadcast
{
    use Queueable;


    public $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
            return ['broadcast','database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
                'user_id' => $notifiable->id,
                'data' => $this->message,
                'read_at' => NULL
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => [
                'user_id' => $notifiable->id,
                'data' => $this->message,
                'read_at' => NULL
            ]
        ];
    }
}
