<?php

namespace Database\Seeders;

use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    // Traits
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys(); 

        $this->truncate("comments");  // Use Trait instead

        $comments = \App\Models\Comment::factory(3)->create();

        $this->enableForeignKeys();
    }
}
