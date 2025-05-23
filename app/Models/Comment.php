<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
