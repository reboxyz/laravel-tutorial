<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $postId = FactoryHelpers::getRandomModelId(Post::class);       
        $userId = FactoryHelpers::getRandomModelId(User::class);

        return [
            'body' => ['abcde'],   // empty
            'user_id' => $userId, 
            'post_id' => $postId, 
        ];
    }
}
