<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;
use App\Interfaces\Services\PostsServiceInterface;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return PostResource::collection(Post::with('comments')->orderBy('id', 'DESC')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {

        Gate::authorize('create', Post::class);

        try {

            return PostResource::make(auth()->user()->posts()->create($request->validated()));
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request, string $id, PostsServiceInterface $postService)
    {

        try {

            $post = Post::findOrFail($id);

            Gate::authorize('update', $post);

            return PostResource::make($postService->updateData($request->validated(), $post));
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, PostsServiceInterface $postService)
    {
        try {

            $post = Post::findOrFail($id);

            Gate::authorize('delete', $post);

            $postService->delete($post);

            return response()->json([
                'data' => [],
                'message' => 'Post deleted successfully!',
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {

            return response()->json([
                'data' => [],
                'error' => 'Something went wrong!',
                'stack' => $th,
            ], Response::HTTP_CONFLICT);
        }
    }
}
