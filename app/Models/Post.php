<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;

use App\Models\Comment;
use App\Models\Like;

class Post extends Model
{
    use GenerateUniqueSlugTrait;

    protected $with = ['comments', 'likes'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {

        if (!$user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
