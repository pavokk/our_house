<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Image;

/*

Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('description')->nullable();
    $table->dateTime('start');
    $table->dateTime('end');
    $table->foreignIdFor(Image::class)->nullable();
    $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
    $table->timestamps();
});

*/

class Event extends Model
{
    use GenerateUniqueSlugTrait, HasFactory;
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
