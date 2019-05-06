<?php

namespace App\Notifications;

use App\ProductModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyLowStock extends Notification
{
    use Queueable;
    public $pro;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductModel $pro)
    {
        $this->pro = $pro;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'pro' => $this->pro,
            'created_at' => Carbon::now()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'pro' => $this->pro,
                'created_at' => Carbon::now()
            ],
        ];
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
            //
        ];
    }
}
