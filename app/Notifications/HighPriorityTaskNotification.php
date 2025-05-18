<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Exception;


class HighPriorityTaskNotification extends Notification
{
    use Queueable;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {

        return ['broadcast'];
    }



    public function toBroadcast($notifiable)
    {
        $data = [
            'title' => 'تسک با اولویت بالا',
            'message' => "تسک «{$this->task['title']}» از اولویت بالایی برخوردار است.",
        ];

        try {
            $key = "notifications:user:{$notifiable->id}";
            Redis::lpush($key, json_encode($data, JSON_UNESCAPED_UNICODE));
            Redis::ltrim($key, 0, 19);
        } catch (\Exception $e) {
            Log::error('خطا در ذخیره‌سازی نوتیفیکیشن در Redis', [
                'user_id' => $notifiable->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \RuntimeException('مشکلی در ارسال پیام به وجود آمده است.');
        }

        return new BroadcastMessage($data);
    }

}
