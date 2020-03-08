<?php

namespace App\Notifications;

use App\Channels\MysqlChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [MySqlChannel::class];
    }

    /**
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 0,
            'from_user_id' => 0,
            'to_user_id' => $notifiable->id,
            'model_id' => $notifiable->id,
            'model_type' => get_class($notifiable),
            'data' => '',
        ];
    }
}
