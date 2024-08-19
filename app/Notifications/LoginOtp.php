<?php

namespace App\Notifications;

use App\Channels\KavehSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginOtp extends Notification
{
    use Queueable;

    private string $phone;
    private string $code;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $phone, string $code)
    {
        
        $this->phone = $phone;
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        return ['sms' => KavehSmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSms(object $notifiable)
    {

        return [
            'phone' => $this->phone,
            'code' => $this->code,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
