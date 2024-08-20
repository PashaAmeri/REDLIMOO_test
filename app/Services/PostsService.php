<?php

namespace App\Services;

use App\Interfaces\Services\PostsServiceInterface;
use App\Models\Comment;
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

    public function delete(Post $post): bool
    {

        return $post->delete();
    }

    public function addComment(array $data): Comment
    {

        return Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $data['post_id'],
            'parent_id' => $data['parent_id'] ?? NULL,
            'content' => $data['content']
        ]);
    }
}
