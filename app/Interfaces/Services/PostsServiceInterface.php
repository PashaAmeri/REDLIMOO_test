<?php

namespace App\Interfaces\Services;

use App\Models\Post;
use App\Models\Comment;

interface PostsServiceInterface
{

    public function updateData(array $data, Post $post): Post;
    public function delete(Post $post): bool;
    public function addComment(array $data): Comment;
}
