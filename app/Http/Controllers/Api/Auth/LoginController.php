<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {

        $tokenRequest = $request->create(
            '/oauth/token',
            'POST',
            [
                'grant_type' => 'otp_grant',
                'client_id' => 'client_id',
                'client_secret' => 'client_secret',
                'phone' => 'phone',
                'otp' => 'otp',
                'scope' => '',
            ]
        );

        $response = app()->handle($tokenRequest);

        return response()->json(json_decode($response->getContent()), $response->getStatusCode());
    }
}
