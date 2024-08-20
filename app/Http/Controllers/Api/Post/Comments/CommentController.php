<?php

namespace App\Http\Controllers\Api\Post\Comments;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Interfaces\Services\PostsServiceInterface;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {

        try {

            return CommentResource::collection(Comment::where('post_id', $id)->where('parent_id', NULL)->with('publisher', 'allReplys')->orderBy('id', 'DESC')->paginate());
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, PostsServiceInterface $postService)
    {

        try {

            $postService->addComment($request->validated());
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
