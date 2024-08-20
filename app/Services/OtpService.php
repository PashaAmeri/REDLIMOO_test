<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Jobs\LoginOtpSmsJob;
use App\Models\Otp as Model;
use App\Notifications\LoginOtp;
use App\Channels\KavehSmsChannel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Notification;
use App\Interfaces\Services\OtpServiceInterface;

class OtpService implements OtpServiceInterface
{

    /**
     * @param string $identifier
     * @param string $type
     * @param int $length
     * @param int $validity
     * @return mixed
     * @throws Exception
     */
    public function generate(string $identifier, string $type, int $length = 4, int $validity = 10): object
    {
        // Model::where('identifier', $identifier)->where('valid', true)->delete();
        Redis::del("otp:{$identifier}");

        switch ($type) {
            case "numeric":
                $token = $this->generateNumericToken($length);
                break;
            case "alpha_numeric":
                $token = $this->generateAlphanumericToken($length);
                break;
            default:
                throw new Exception("{$type} is not a supported type");
        }

        // Model::create([
        //     'identifier' => $identifier,
        //     'token' => $token,
        //     'validity' => $validity
        // ]);
        Redis::setex("otp:{$identifier}", $validity * 60, $token);

        // send otp sms to user phone
        dispatch(new LoginOtpSmsJob($identifier, $token));

        return (object)[
            'status' => true,
            'token' => $token,
            'message' => 'OTP generated.'
        ];
    }

    /**
     * @param string $identifier
     * @param string $token
     * @return mixed
     */
    public function validate(string $identifier, string $token): object
    {
        // $otp = Model::where('identifier', $identifier)->where('token', $token)->first();
        $otp = Redis::get("otp:{$identifier}");

        if ($otp === $token) {
            // Invalidate the OTP by deleting it from Redis
            Redis::del("otp:{$identifier}");

            return (object)[
                'status' => true,
                'message' => 'OTP Code apporoved.'
            ];
        } else {
            return (object)[
                'status' => false,
                'message' => 'OTP code is not valid.'
            ];
        }
    }

    public function check(string $identifier, string $token): object
    {
        // $otp = Model::where('identifier', $identifier)->where('token', $token)->first();
        $otp = Redis::get("otp:{$identifier}");

        if ($otp === $token) {
            return (object)[
                'status' => true,
                'message' => 'OTP Code apporoved.'
            ];
        } else {
            return (object)[
                'status' => false,
                'message' => 'OTP Code is not valid.'
            ];
        }
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    private function generateNumericToken(int $length = 4): string
    {
        $i = 0;
        $token = "";

        while ($i < $length) {
            $token .= random_int(0, 9);
            $i++;
        }

        return $token;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateAlphanumericToken(int $length = 4): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($characters), 0, $length);
    }
}
