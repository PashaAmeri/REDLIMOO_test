<?php

namespace App\Interfaces\Services;

use App\Models\Post;

interface PostsServiceInterface
{

    public function updateData(array $data, Post $post): Post;
}
