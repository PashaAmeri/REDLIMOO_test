<?php

namespace App\Services;

use App\Interfaces\Services\PostsServiceInterface;
use App\Models\Post;

class PostsService implements PostsServiceInterface
{

    public function updateData(array $data, Post $post): Post
    {

        $post->title = $data['title'];
        $post->content = $data['content'];

        $post->save();

        return $post;
    }
}
