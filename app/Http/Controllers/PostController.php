<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Rules\IntegerArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET api/posts?page=2&page_size=10
     */
    public function index(Request $request)
    {
        //report(GeneralJsonException::class); // Helper method to explicit call the GeneralJsonException's report()
        //abort(404);   // Helper method to abort with HTTP Status Code

        $pageSize = $request->page_size ?? 20;

        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        //StorePostRequest $request, // Note! This is much cleaner way to validate request
        Request $request, 
        PostRepository $repository
        )
    {   
        $payload = $request->only([
            'title',
            'body',
            'user_ids'
        ]);

        // Note! Using Validator
        $validator = Validator::validate($payload, [
            'title' => 'string|required',
            'body' => ['string', 'required'],
            'user_ids' => [
                'array',
                'required',
                new IntegerArray()
            ],
        ], [
            'title.string' => 'Title must be a string.',
            'title.required' => 'Please enter a value for title.',
            'body.required' => 'Please enter a value for body.'
        ], [
           'user_ids' => 'USER IDs' 
        ]);

        $created = $repository->create($payload);
       
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
        $deleted = $repository->forceDelete($post);

        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}
