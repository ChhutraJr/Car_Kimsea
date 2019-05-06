<?php

namespace App\Notifications;

use App\CustomerModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyPMReminder extends Notification
{
    use Queueable;
    public $cus;
    public $first_service;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerModel $cus,$first_service)
    {
        $this->cus=$cus;
        $this->first_service=$first_service;
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
            'cus' => $this->cus,
            'first_service'=>$this->first_service,
            'created_at' => Carbon::now()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'cus' => $this->cus,
                'first_service' => $this->first_service,
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
