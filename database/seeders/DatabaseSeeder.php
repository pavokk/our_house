<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // It's good practice to disable foreign key checks while seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear out existing data to start fresh
        User::truncate();
        Image::truncate();
        Post::truncate();
        Event::truncate();
        Comment::truncate();
        Like::truncate();

        // --- 1. SEED IMAGES ---
        // Create a collection of images to be used by other models.
        $images = Image::factory(20)->create();
        $this->command->info('✅ Images table seeded!');

        // --- 2. SEED USERS ---
        // Create one specific admin user for easy login
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'image_id' => $images->random()->id,
        ]);

        // Create additional random users
        $users = User::factory(15)->create([
            // Randomly assign an image_id to some users, leave others null
            'image_id' => fn () => rand(0, 1) ? $images->random()->id : null,
        ]);
        $allUsers = $users->push($adminUser); // Combine all users for later use
        $this->command->info('✅ Users table seeded!');

        // --- 3. SEED EVENTS ---
        $events = Event::factory(10)
            ->sequence(fn () => [
                'user_id' => $allUsers->random()->id,
                'image_id' => $images->random()->id,
            ])
            ->create();
        $this->command->info('✅ Events table seeded!');

        // --- 4. SEED POSTS ---
        $posts = Post::factory(40)
             ->sequence(fn () => [
                'user_id' => $allUsers->random()->id,
                // Randomly assign an image_id to some posts, leave others null
                'image_id' => rand(0, 1) ? $images->random()->id : null,
             ])
             ->create();
        $this->command->info('✅ Posts table seeded!');

        // --- 5. SEED COMMENTS (Posts & Events) ---
        $comments = collect(); // To store all created comments for later

        // Create comments for Posts
        foreach ($posts as $post) {
            $newComments = Comment::factory(rand(1, 5))->create([
                'user_id' => $allUsers->random()->id,
                'post_id' => $post->id,
                'event_id' => null, // Ensure it's not for an event
            ]);
            $comments = $comments->merge($newComments);
        }

        // Create comments for Events
        foreach ($events as $event) {
            $newComments = Comment::factory(rand(1, 5))->create([
                'user_id' => $allUsers->random()->id,
                'post_id' => null, // Ensure it's not for a post
                'event_id' => $event->id,
            ]);
            $comments = $comments->merge($newComments);
        }
        $this->command->info('✅ Post & Event comments seeded!');

        // Create some nested comments (replies)
        foreach ($comments->take(20) as $comment) { // Create replies for the first 20 comments
            $replies = Comment::factory(rand(1, 3))->create([
                'user_id' => $allUsers->random()->id,
                'post_id' => $comment->post_id, // Reply belongs to the same post/event
                'event_id' => $comment->event_id,
                'parent_id' => $comment->id, // This makes it a reply
            ]);
            $comments = $comments->merge($replies);
        }
        $this->command->info('✅ Nested comments seeded!');


        // --- 6. SEED LIKES (Posts, Events, & Comments) ---
        // Add likes to Posts
        foreach ($posts as $post) {
            if (rand(0, 1)) { // 50% chance to get likes
                foreach ($allUsers->random(rand(1, 5)) as $user) {
                    Like::factory()->create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }

        // Add likes to Events
        foreach ($events as $event) {
             if (rand(0, 1)) {
                foreach ($allUsers->random(rand(1, 8)) as $user) {
                    Like::factory()->create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }

        // Add likes to Comments
        foreach ($comments as $comment) {
            if (rand(0, 3) == 1) { // 25% chance for a comment to get likes
                foreach ($allUsers->random(rand(1, 3)) as $user) {
                    Like::factory()->create([
                        'user_id' => $user->id,
                        'comment_id' => $comment->id,
                    ]);
                }
            }
        }
        $this->command->info('✅ Likes table seeded!');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
