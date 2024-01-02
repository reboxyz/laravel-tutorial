<?php 

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        $created = DB::transaction(function () use ($attributes)  {
            $created = Post::query()->create([
                'title' => data_get($attributes,'title', 'Untitled'),
                'body' => data_get($attributes,'body'),
            ]);
            
            /*
            if (! $created) {
                throw new GeneralJsonException('Failed to create model.');
            }
            */

            throw_if(! $created, GeneralJsonException::class,'Failed to create model.');

            if ($userIds = data_get($attributes,'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
        return $created;
    }

    public function update($post, array $attributes)
    {
        return DB::transaction(function () use ($post, $attributes) {
            $updated = $post->update([
                'title' => data_get($attributes,'title', $post->title),
                'body' => data_get($attributes,'body', $post->body),
            ]);
    
            /*
            if (! $updated) {
                throw new \Exception('Failed to update model.');
            }
            */
            throw_if(! $updated, GeneralJsonException::class,'Failed to update model.');

            if ($userIds = data_get($attributes,'user_ids')) {
                $post->users()->sync($userIds);
            }

            return $post;
        });
    }

    public function forceDelete($post)
    {
        return DB::transaction(function () use ($post) {
            $deleted = $post->forceDelete();

            /*
            if (! $deleted) {
                throw new \Exception('Failed to delete model.');
            }
            */
            throw_if(! $deleted, GeneralJsonException::class,'Failed to delete model.');

            return $deleted;
        });
    }
}

?>