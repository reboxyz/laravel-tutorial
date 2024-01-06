<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        // 1. Define the goal
        // test if create() will actually create a record in the DB

        // 2. Replicate the env / restriction
        $repository = $this->app->make(UserRepository::class);

        // 3. define the source of truth
        $payload = [
            'name' => 'heyaa',
            'email' => 'abc@example.com',
            'password' => 'secret',
        ];

        // 4. compare the result
        $result = $repository->create($payload);

        $this->assertSame($payload['name'], $result->name, 'User created does not have the same name.');
    }

    public function test_update()
    {
        $repository = $this->app->make(UserRepository::class);

        $dummyUser = User::factory()->create();
        
        // Source of truth
        $payload = [
            'name'=> 'winnux',
        ];

        // Compare
        $updated = $repository->update($dummyUser, $payload);
        $this->assertSame($payload['name'], $updated->name);
    }

    public function test_delete()
    {
        $repository = $this->app->make(UserRepository::class);
        $dummy = User::factory()->create();
        $deleted = $repository->forceDelete($dummy);

        // verify if it is deleted
        $found = User::query()->find($dummy->id);

        $this->assertNull($found);
    }

    public function test_delete_will_throw_exception_when_delete_user_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(UserRepository::class);
        $dummy = User::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummy);
    }
}
