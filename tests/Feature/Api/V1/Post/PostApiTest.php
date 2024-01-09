<?php

namespace Tests\Feature\Api\V1\Post;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;  // Reset DB

    protected $uri = '/api/v1/posts';

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->make();
        $this->actingAs($user);
    }
    

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
        Event::fake();
        $dummy = Post::factory()->make();

        $dummyUser = User::factory()->create();

        $response = $this->json('post', $this->uri, array_merge($dummy->toArray(), ['user_ids' => [$dummyUser->id]]));

        $result = $response->assertStatus(201)->json('data');
        Event::assertDispatched(PostCreated::class);
        $result = collect($result)->only(array_keys($dummy->getAttributes()));

        $result->each(function ($value, $field) use($dummy){
            $this->assertSame(data_get($dummy, $field), $value, 'Fillable is not the same.');
        });
    }

    public function test_update()
    {
        $dummy = Post::factory()->create();
        $dummy2 = Post::factory()->make();
        Event::fake();
        $fillables = collect((new Post())->getFillable());

        $fillables->each(function ($toUpdate) use($dummy, $dummy2){
            $response = $this->json('patch', $this->uri . '/' . $dummy->id, [
                $toUpdate => data_get($dummy2, $toUpdate),
            ]);

            $result = $response->assertStatus(200)->json('data');
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
