<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;
use App\Models\Post;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // The ->change() method handles dropping the old index automatically.
            $table->foreignIdFor(Post::class)->nullable()->change();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreignIdFor(Event::class)->nullable()->after('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->after('event_id')->constrained('comments')->cascadeOnDelete();
        });

        Schema::table('likes', function (Blueprint $table) {
            // Re-defining the foreign keys is enough to update them.
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreign('comment_id')->references('id')->on('comments')->cascadeOnDelete();
            $table->foreignIdFor(Event::class)->nullable()->after('comment_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Event::class);
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('comment_id')->references('id')->on('comments');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropConstrainedForeignIdFor(Event::class);
            // The ->change() method handles dropping the old index automatically.
            $table->foreignIdFor(Post::class)->nullable(false)->change();
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }
};
