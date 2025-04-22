<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class MigratePostImages extends Command
{
    protected $signature = 'migrate:post-images';
    protected $description = 'Migrate post image filenames to the images table';

    public function handle()
    {
        DB::transaction(function () {
            Post::whereNotNull('image')->chunk(100, function ($posts) {
                foreach ($posts as $post) {
                    $image = Image::create([
                        'image' => $post->image,
                        'type' => 'posts',
                        'alt' => 'Migrated image',
                        // add any other required fields your Image model uses
                    ]);

                    $post->image_id = $image->id;
                    $post->save();
                }
            });
        });

        $this->info('Images migrated successfully.');
    }
}

// app/Console/Commands/MigratePostImages.php

