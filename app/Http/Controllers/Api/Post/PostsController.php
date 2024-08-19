<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return PostResource::collection(Post::orderBy('id', 'DESC')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request): PostResource|r
    {

        Gate::authorize('create', Post::class);

        try {

            return PostResource::make(auth()->user()->posts()->create($request->validated()));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
