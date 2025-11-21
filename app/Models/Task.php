<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory, Commentable, Likeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'user_id',     // The creator
        'assignee_id', // The person it's assigned to
        'image_id',
        'status',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'assignee_id' => 'integer',
        'image_id' => 'integer',
        'status' => TaskStatus::class,
        'due_date' => 'datetime',
    ];

    /**
     * The user who CREATED the task.
     * (This is the relationship for the 'user_id' column)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The user who is ASSIGNED the task.
     * (This is the relationship for the 'assignee_id' column)
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * The task's image.
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
