<?php 

namespace App\Repositories;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        $created = DB::transaction(function () use ($attributes)  {
            $created = User::query()->create([
                'name' => data_get($attributes,'name'),
                'email' => data_get($attributes,'email'),
                'password' => data_get($attributes,'password'), // Todo: Hashing
            ]);

            throw_if(! $created, GeneralJsonException::class,'Failed to create model.');
    
            event(new UserCreated($created));

            return $created;
        });
        return $created;
    }

    public function update($user, array $attributes)
    {
        return DB::transaction(function () use ($user, $attributes) {
            $updated = $user->update([
                'name' => data_get($attributes,'name', $user->name),
                'email' => data_get($attributes,'email', $user->email),
                'password' => data_get($attributes,'password'),
            ]);
    
            /*
            if (! $updated) {
                throw new \Exception('Failed to update model.');
            }
            */

            throw_if(! $updated, GeneralJsonException::class,'Failed to update model.');

            event(new UserUpdated($user));

            return $user;
        });
    }

    public function forceDelete($user)
    {
        return DB::transaction(function () use ($user) {
            $deleted = $user->forceDelete();

            /*
            if (! $deleted) {
                throw new \Exception('Failed to delete model.');
            }
            */

            throw_if(! $deleted, GeneralJsonException::class,'Failed to delete model.');

            event(new UserDeleted($user));

            return $deleted;
        });
    }
}