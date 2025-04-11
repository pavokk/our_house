<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Image extends Model
{

    protected $fillable = [
        "image",
        "type",
        "alt",
    ];
    public function user() {
        return $this->hasOne(User::class);
    }
}
