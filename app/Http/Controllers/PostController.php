<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET api/posts?page=2&page_size=10
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;

        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PostRepository $repository)
    {   
        $created = $repository->create($request->only([
            'title',
            'body',
            'user_ids'
        ]));
       
        return new PostResource($created);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $deleted = $repository->foreceDelete($post);

        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}
