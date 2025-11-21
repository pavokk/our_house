<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Image;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('type')->nullable();

            // This is the CREATOR
            $table->foreignIdFor(User::class) // This creates 'user_id'
                  ->constrained()
                  ->onDelete('cascade');

            // This is the ASSIGNEE
            $table->foreignId('assignee_id')
                  ->nullable() // Allows tasks to be unassigned
                  ->constrained('users') // Specifies it points to the 'users' table
                  ->nullOnDelete(); // If assigned user is deleted, set this field to NULL

            $table->foreignIdFor(Image::class)->nullable()->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
