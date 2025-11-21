<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a few specific Users
        $user1 = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'type' => 'admin',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'type' => 'guest',
        ]);

        // 2. Create 10 other random Users
        $otherUsers = User::factory(10)->create();

        // 3. Create Posts, Events, and Tasks for our users
        // Let's have each user create a mix of content
        foreach (User::all() as $user) {
            Post::factory(3)->create(['user_id' => $user->id]);
            Event::factory(1)->create(['user_id' => $user->id]);

            Task::factory(1)->create([
                'user_id' => $user->id, // Creator
            ]);
        }

        // 4. Create polymorphic Comments
        $posts = Post::all();
        $events = Event::all();
        $tasks = Task::all();

        foreach ($posts as $post) {
            // Create 3 top-level comments for each post
            $comments = Comment::factory(3)->create([
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
                'user_id' => $otherUsers->random()->id
            ]);

            // Create a few replies (comment on a comment)
            Comment::factory(1)->create([
                'commentable_id' => $post->id, // Still belongs to the post
                'commentable_type' => Post::class,
                'parent_id' => $comments->first()->id, // But is a reply
                'user_id' => $otherUsers->random()->id
            ]);
        }

        // (You can copy the loop above for Events and Tasks)

        // 5. Create polymorphic Likes
        foreach ($posts as $post) {
            // Like the post itself
            Like::factory(5)->create([
                'likeable_id' => $post->id,
                'likeable_type' => Post::class,
                'user_id' => $otherUsers->random()->id
            ]);
        }

        foreach (Comment::all() as $comment) {
            // Like a comment
            Like::factory(2)->create([
                'likeable_id' => $comment->id,
                'likeable_type' => Comment::class,
                'user_id' => $otherUsers->random()->id
            ]);
        }
    }
}
