<?php

namespace App\Notifications;

use App\ProductModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class NotifyNewProduct extends Notification
{
    use Queueable;
    public $pro;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductModel $pro, User $user)
    {
        $this->pro = $pro;
        $this->user = $user;
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
            'user' => $this->user,
            'created_at' => Carbon::now()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'pro' => $this->pro,
                'user' => $this->user,
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
