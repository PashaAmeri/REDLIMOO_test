<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\Services\OtpServiceInterface;
use App\Interfaces\Services\UsersServiceInterface;
use Carbon\Carbon;

class LoginController extends Controller
{

    // protected property fot service instance
    private UsersServiceInterface $userService;
    private OtpServiceInterface $otpService;

    /**
     * 
     *  Loading Serivce instances 
     */
    public function __construct(UsersServiceInterface $userService, OtpServiceInterface $otpService)
    {

        $this->userService = $userService;
        $this->otpService = $otpService;
    }

    public function login(LoginRequest $request)
    {

        // try {

            $otp = $this->otpService->check($request->phone, $request->otp);

            if ($otp->status) {

                return response()->json([
                    'status' => false,
                    'username' => $request->phone,
                    'message' => $otp->message
                ], Response::HTTP_NOT_ACCEPTABLE);
            }

            $token = $this->userService->generateToken($request->phone);

            return response()->json([
                'token_type' => 'Bearer',
                'expires_in' => round(Carbon::now()->diffInSeconds($token->token->expires_at)),
                'access_token' => $token->tokenResult->accessToken,
            ]);
        // } catch (\Throwable $th) {

        //     return response()->json([
        //         'data' => [],
        //         'error' => 'Something went wrong!',
        //         'stack' => $th,
        //     ], Response::HTTP_CONFLICT);
        // }
    }
}
