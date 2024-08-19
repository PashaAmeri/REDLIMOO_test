<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;


class WriterController extends Controller
{

    public function index(string $id)
    {

        try {

            return PostResource::collection(Post::where('user_id', $id)->orderBy('id', 'DESC')->paginate());
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
