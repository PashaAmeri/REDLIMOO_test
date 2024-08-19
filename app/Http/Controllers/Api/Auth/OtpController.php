<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpPhoneRequest;
use App\Interfaces\Services\OtpServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OtpController extends Controller
{

    /**
     * properties to load services 
     */
    private OtpServiceInterface $otpService;

    /**
     * construct to load services and repositry needed to execute the controller
     */
    public function __construct(OtpServiceInterface $otpService)
    {

        $this->otpService = $otpService;
    }

    /**
     * generate new one time password(OTP) and send it via SMS.
     */
    public function generate(OtpPhoneRequest $request)
    {

        try {

            $otp = $this->otpService->generate($request->phone, 'numeric', 6, 2);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'username' => $request->phone,
                'message' => __('errors.conflict')
            ], Response::HTTP_CONFLICT);
        }

        return response()->json([
            'status' => $otp->status,
            'username' => $request->phone,
            'message' => 'OTP code sent.'
        ], Response::HTTP_CREATED);
    }

    /**
     * check validation of OTP code generated and sent by SMS.
     */
    public function check(Request $request)
    {

        try {

            $otp = $this->otpService->check($request->phone, $request->code);

            if (!$otp->status) {

                return response()->json([
                    'status' => false,
                    'username' => $request->phone,
                    'message' => $otp->message
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'username' => $request->phone,
                'message' => __('errors.conflict')
            ], Response::HTTP_CONFLICT);
        }

        return response()->json([
            'status' => true,
            'username' => $request->phone,
            'message' => 'OTP code is valid.'
        ], Response::HTTP_ACCEPTED);
    }
}
