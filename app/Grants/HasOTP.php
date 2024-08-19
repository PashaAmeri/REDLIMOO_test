<?php

namespace App\Grants;

use League\OAuth2\Server\Exception\OAuthServerException;

trait HasOTP
{
    public $phoneNumberColumn = 'phone';
    public $OTPColumn = 'otp';
    public $OTPExpireTime = 15;

    /**
     * @param  $phoneNumber
     * @param  $otp
     * @return mixed
     */
    public function validateForOTPCodeGrant($phoneNumber, $otp)
    {
        $user = $this->where($this->getPhoneNumberColumn(), $phoneNumber)->first();

        if (! $user) {
            throw OAuthServerException::invalidRequest('phone', 'phone');
        }

        if (! $user->otp || $user->otp != $otp) {
            throw OAuthServerException::invalidRequest('otp', 'otp is wrong ');
        }

        if ($user->updated_at->diff(now())->format('%i min') > $this->getOTPExpireTime()) {
            throw  OAuthServerException::invalidRequest('otp', 'otp code expired try  get it  again');
        }
        $this->removeOtp($user);

        return $user;
    }

    protected function getPhoneNumberColumn()
    {
        return $this->phoneNumberColumn;
    }

    protected function getOTPExpireTime()
    {
        return $this->OTPExpireTime;
    }

    public function removeOtp($user)
    {
        $user->save([$this->getOTPColumn() => null]);
    }

    protected function getOTPColumn()
    {
        return $this->OTPColumn;
    }
}
