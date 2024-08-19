<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserInfoResource;


class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {

        try {

            return UserInfoResource::make(auth()->user());
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
