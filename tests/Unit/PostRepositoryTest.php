<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase; // Note! Use this version of 'TestCase' and not the PHPUnit version

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_create(): void
    {
        // 1. Define the goal
        // Test if create will actually create a record in DB

        // 2. Replicate the env/restriction
        $repository = $this->app->make(PostRepository::class);        

        // 3. Define the source of truth
        $payload = [
            "title"=> "heyaa",
            'body' => [],
        ];

        // 4. Compare the result
        $result = $repository->create($payload);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title');
    }

    public function test_update(): void
    {
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        $payload = [
            "title"=> "abc123",
        ];

        $updated = $repository->update($dummyPost, $payload);
        $this->assertSame($payload['title'], $updated->title, 'Post updated does not have the same title');
    }

    public function test_delete(): void
    {
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()->first();

        $deleted = $repository->forceDelete($dummyPost);

        $found = Post::query()->find($dummyPost->id);

        $this->assertSame(null, $found, 'Post is not deleted'); 
    }

    public function test_delete_will_throw_exception_post_not_exist(): void
    {
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->make()->first();  // Note! This is make and NOT create which will guarantee it will not exists in the the DB

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummyPost);
    }
}
