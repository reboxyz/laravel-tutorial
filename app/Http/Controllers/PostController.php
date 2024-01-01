<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->get();
        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $post = DB::transaction(function () use ($request)  {
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
            ]);
    
            $post->users()->sync($request->user_ids);
            return $post;
        });
       
        return new JsonResponse([
            'data'=> $post
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new JsonResponse([
            'data'=> $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //$post->update($request->only(['title','body']));

        $updated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body,
        ]);

        if (!$updated)
        {
            return new JsonResponse([
                'errors' => [
                    'Failed to update model'
                ]
            ], 400); // Bad request
        }

        return new JsonResponse([
            'data'=> $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $deleted = $post->forceDelete();

        if (!$deleted)
        {
            return new JsonResponse([
                'errors' => [
                    'Failed to delete model'
                ]
            ], 400); // Bad request
        }

        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}
