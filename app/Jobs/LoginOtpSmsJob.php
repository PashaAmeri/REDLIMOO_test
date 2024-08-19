<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Notifications\LoginOtp;
use App\Channels\KavehSmsChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class LoginOtpSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $phone;
    private string $code;

    /**
     * Create a new job instance.
     */
    public function __construct(string $phone, string $code)
    {
        
        $this->phone = $phone;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        // Notification::send($this->phone, new LoginOtp($this->phone, $this->code));
        Notification::route('sms', $this->phone)->notify(new LoginOtp($this->phone, $this->code));
    }
}
