<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Image;
use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;

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
    use GenerateUniqueSlugTrait, HasFactory, Commentable, Likeable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'start',
        'end',
        'image_id',
        'user_id',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected $with = ['comments', 'likes'];

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
