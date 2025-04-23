<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Image;

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

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function isLikedBy($user)
    {

        if (!$user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
