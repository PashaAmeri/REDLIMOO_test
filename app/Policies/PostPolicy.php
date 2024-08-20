<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {

        return auth()->user()->checkPermissionTo('create posts') ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {

        return auth()->user()->checkPermissionTo('update posts') and $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {

        return auth()->user()->checkPermissionTo('delete posts') and $user->id === $post->user_id;
    }
}
