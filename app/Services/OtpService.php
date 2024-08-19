<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Otp as Model;
use App\Notifications\LoginOtp;
use App\Channels\KavehSmsChannel;
use Illuminate\Support\Facades\Notification;
use App\Interfaces\Services\OtpServiceInterface;
use App\Jobs\LoginOtpSmsJob;

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
        Model::where('identifier', $identifier)->where('valid', true)->delete();

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

        Model::create([
            'identifier' => $identifier,
            'token' => $token,
            'validity' => $validity
        ]);

        // send otp sms to user phone
        dispatch(new LoginOtpSmsJob($identifier, $token));

        return (object)[
            'status' => true,
            'token' => $token,
            'message' => 'OTP generated'
        ];
    }

    /**
     * @param string $identifier
     * @param string $token
     * @return mixed
     */
    public function validate(string $identifier, string $token): object
    {
        $otp = Model::where('identifier', $identifier)->where('token', $token)->first();

        if ($otp instanceof Model) {
            if ($otp->valid) {
                $now = Carbon::now();
                $validity = $otp->created_at->addMinutes($otp->validity);

                $otp->update(['valid' => false]);

                if (strtotime($validity) < strtotime($now)) {
                    return (object)[
                        'status' => false,
                        // 'message' => 'OTP Expired'
                        'message' => 'کد یک بار مصرف منقضی شده است.'
                    ];
                }

                $otp->update(['valid' => false]);

                return (object)[
                    'status' => true,
                    // 'message' => 'OTP is valid'
                    'message' => 'کد یک بار مصرف معتبر است.'
                ];
            }

            $otp->update(['valid' => false]);

            return (object)[
                'status' => false,
                // 'message' => 'OTP is not valid'
                'message' => 'کد یک بار مصرف معتر نمی باشد.'
            ];
        } else {
            return (object)[
                'status' => false,
                // 'message' => 'OTP does not exist'
                'message' => 'کد یک بار مصرف معتر نمی باشد.'
            ];
        }
    }

    public function check(string $identifier, string $token): object
    {
        $otp = Model::where('identifier', $identifier)->where('token', $token)->first();

        if ($otp instanceof Model) {
            if ($otp->valid) {
                $now = Carbon::now();
                $validity = $otp->created_at->addMinutes($otp->validity);

                if (strtotime($validity) < strtotime($now)) {
                    return (object)[
                        'status' => false,
                        // 'message' => 'OTP Expired'
                        'message' => 'کد یک بار مصرف منقضی شده است.'
                    ];
                }

                return (object)[
                    'status' => true,
                    // 'message' => 'OTP is valid'
                    'message' => 'کد یک بار مصرف معتبر است.'
                ];
            }

            return (object)[
                'status' => false,
                // 'message' => 'OTP is not valid'
                'message' => 'کد یک بار مصرف معتر نمی باشد.'
            ];
        } else {
            return (object)[
                'status' => false,
                // 'message' => 'OTP does not exist'
                'message' => 'کد یک بار مصرف معتر نمی باشد.'
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
