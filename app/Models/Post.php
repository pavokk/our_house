<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueSlugTrait;

class Post extends Model
{
    use GenerateUniqueSlugTrait;
}
