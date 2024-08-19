<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Interfaces\Services\UsersServiceInterface;

class UpdateInfoController extends Controller
{

    protected UsersServiceInterface $userService;

    public function __construct(UsersServiceInterface $userService)
    {

        $this->userService = $userService;
    }

    public function __invoke(ProfileUpdateRequest $request)
    {

        try {

            $user = $this->userService->updateProfile(auth()->user(), $request->validated());

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'bio' => $user->bio
                ],
                'success' => true,
                'message' => 'User profile updated successfully.',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
