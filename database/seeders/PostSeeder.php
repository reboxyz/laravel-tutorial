<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelpers;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    // Traits
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys(); 

        $this->truncate("posts");  // Use Trait instead

        $posts = Post::factory(60)
            ->has(Comment::factory(3), 'comments')
        //    ->untitled()
            ->create();
    
        // Seed the post_user pivot table
        $posts->each(function (Post $post) {
            $post->users()->sync([FactoryHelpers::getRandomModelId(User::class)]);
        });

        $this->enableForeignKeys();
    }
}
