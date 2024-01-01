<?php 

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    public function create(array $attributes)
    {
        $created = DB::transaction(function () use ($attributes)  {
            $created = Post::query()->create([
                'title' => data_get($attributes,'title', 'Untitled'),
                'body' => data_get($attributes,'body'),
            ]);
    
            if ($userIds = data_get($attributes,'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
        return $created;
    }

    public function update(Post $post, array $attributes)
    {
        return DB::transaction(function () use ($post, $attributes) {
            $updated = $post->update([
                'title' => data_get($attributes,'title', $post->title),
                'body' => data_get($attributes,'body', $post->body),
            ]);
    
            if (! $updated) {
                throw new \Exception('Failed to update model.');
            }

            if ($userIds = data_get($attributes,'user_ids')) {
                $post->users()->sync($userIds);
            }

            return $post;
        });
    }

    public function foreceDelete(Post $post)
    {
        return DB::transaction(function () use ($post) {
            $deleted = $post->forceDelete();

            if (! $deleted) {
                throw new \Exception('Failed to delete model.');
            }

            return $deleted;
        });
    }
}

?>