<?php

namespace App\Channels;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class KavehSmsChannel {

    public function send($notifiable, Notification $notification)
    {

        $response = Http::withoutVerifying()
            ->withOptions(['verify' => false])
            ->get('https://api.kavenegar.com/v1/4D2B693469746930664F33666B35736A79714B33434D6D72626B47365464474F435753486C455563574E733D/verify/lookup.json', [
                'receptor' => $notifiable->routes['sms'],
                'token' => $notification->toSms($notifiable)['code'],
                'template' => 'login-otp',
                'type' => 'sms',
            ]);
    }
}