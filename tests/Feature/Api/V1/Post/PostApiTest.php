<?php

namespace Tests\Feature\Api\V1\Post;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;  // Reset DB

    public function test_index()
    {
        // load data in db
        $post = Post::factory(10)->create();
        $postIds = $post->map(fn ($post) => $post->id)->toArray();

        // call index endpoint
        $response = $this->json('get', '/api/v1/posts');

        // assert status
        $response->assertStatus(200);

        // verify records
        //dump($response->json());
        $data = $response->json('data');

        //dump($data);
        collect($data)->each(fn ($post) => $this->assertTrue(in_array($post['id'], $postIds)));
    }

    public function test_show()
    {
        $dummy = Post::factory()->create();
        $response = $this->json('get', '/api/v1/posts/' . $dummy->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals($dummy->id, $result['id']);
    }

    public function test_create()
    {
        Event::fake(); // Note! This is need to test Events

        $dummy = Post::factory()->make();

        $response = $this->json('post','/api/v1/posts', $dummy->toArray());

        Event::assertDispatched(PostCreated::class);

        $result = $response->assertStatus(201)->json('data');

        // Convert result to an object in which the keys are those defined in the original 'dummy' object
        $result = collect($result)->only(array_keys($dummy->getAttributes()));
        
        $result->each(function ($value, $field) use ($dummy) {
            $this->assertSame(data_get($dummy, $field), $value);
        });   
    }

    public function test_update()
    {
        $dummy = Post::factory()->create(); // To update
        $dummy2 = Post::factory()->make();  // Data to update

        Event::fake();  // Note! This is need to test Events
        
        $fillables = collect((new Post())->getFillable());

        $fillables->each(function ($toUpdate) use ($dummy, $dummy2) {
            $response = $this->json('patch', '/api/v1/posts/' . $dummy->id, [
                $toUpdate => data_get($dummy2, $toUpdate),
            ]);

            $result = $response->assertStatus(200)->json('data');
            //dump($result);
            Event::assertDispatched(PostUpdated::class);
            $this->assertSame(data_get($dummy2, $toUpdate), data_get($dummy->refresh(), $toUpdate),'Failed to update model.');            
        });
    }

    public function test_delete()
    {
        $dummy = Post::factory()->create();
        Event::fake();

        $response = $this->json('delete','/api/v1/posts/'. $dummy->id);
        Event::assertDispatched(PostDeleted::class);

        $result = $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);
        Post::query()->findOrFail($dummy->id);
    }

}
