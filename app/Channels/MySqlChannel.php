<?php

namespace App\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use App\Models\Notification as NotificationModel;

/**
 * Class MysqlChannel
 *
 * @package App\Channels
 */
class MySqlChannel extends DatabaseChannel
{
    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return Model
     */
    public function send($notifiable, Notification $notification)
    {
        return NotificationModel::create($this->buildPayload($notifiable, $notification));
    }

    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return array
     */
    public function buildPayload($notifiable, Notification $notification)
    {
        $data = $this->getData($notifiable, $notification);

        return [
            'type' => $data['type'] ?? null,
            'from_user_id' => $data['from_user_id'] ?? 0,
            'to_user_id' => $data['to_user_id'] ?? 0,
            'model_id' => $data['model_id'] ?? 0,
            'model_type' => $data['model_type'] ?? null,
            'data' => $data['data'] ?? null,
            'read_at' => null,
        ];
    }
}
