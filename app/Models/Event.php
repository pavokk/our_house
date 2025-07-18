<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    //
}
