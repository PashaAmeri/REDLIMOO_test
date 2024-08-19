<?php

namespace App\Interfaces\Services;

interface OtpServiceInterface
{

    public function generate(string $identifier, string $type, int $length = 4, int $validity = 10): object;
    public function validate(string $identifier, string $token): object;
    public function check(string $identifier, string $token): object;
}
