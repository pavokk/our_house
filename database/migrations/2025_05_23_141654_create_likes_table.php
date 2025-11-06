<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Event; // Added this import

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('heart');

            $table->foreignIdFor(Post::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Comment::class)->nullable()->constrained()->cascadeOnDelete();

            $table->foreignIdFor(Event::class)->nullable()->constrained()->cascadeOnDelete();

            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
