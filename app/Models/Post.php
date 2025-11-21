<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;

use App\Models\User;
use App\Models\Image;

class Post extends Model
{
    use GenerateUniqueSlugTrait, HasFactory, Commentable, Likeable;

    protected $with = ['comments', 'likes'];

    protected static function booted(): void
    {
        static::deleting(function (Post $post) {
            $post->comments()->delete();
            $post->likes()->delete();
        });
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
