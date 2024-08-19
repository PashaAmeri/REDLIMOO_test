<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Services\OtpServiceInterface;
use App\Interfaces\Services\UsersServiceInterface;

class RegisterController extends Controller
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

    /**
     * 
     *  store user data 
     */
    public function store(RegisterRequest $request)
    {

        try {

            $otp = $this->otpService->check($request->phone, $request->otp);

            if (!$otp->status) {

                return response()->json([
                    'status' => false,
                    'username' => $request->phone,
                    'message' => $otp->message
                ], Response::HTTP_NOT_ACCEPTABLE);
            }

            // create user
            $user = $this->userService->storeUser($request->validated());

            // chack if the provided passport client is valid or not
            if (!$user) {

                // returning a 406 error
                return response()->json([
                    'error' => 'invalid_client',
                    'error_description' => 'Client authentication failed',
                    'message' => 'Client authentication failed'
                ], Response::HTTP_NOT_ACCEPTABLE);
            }

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                ],
                'message' => 'User created successfully',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
