<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];

    // ---------- Relations

    // Publisher relation: a comment belongs to a user (publisher)
    public function publisher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Replies relation: a comment can have many replies
    public function allReplys()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
