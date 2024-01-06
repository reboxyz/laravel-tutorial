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

/**
 * @group Post Management
 * APIs to manage post.
*/
class PostController extends Controller
{
    /**
    * Display a listing of posts.
    *
    * Gets a list of posts.
    *
    * @queryParam page_size int Size per page. Defaults to 20. Example: 20
    * @queryParam page int Page to view. Example: 1
    *
    * @apiResourceCollection App\Http\Resources\PostResource
    * @apiResourceModel App\Models\Post
    * @return PostResource
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
     * Store a newly created post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  StorePostRequest  $request
     * @return PostResource
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
     * Display the specified post.
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return PostResource | JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)
    {
        $payload = $request->only([
            'title',
            'body',
            'user_ids'
        ]);

        $post = $repository->update($post, $payload);

        return new PostResource($post);
    }

    /**
     * Remove the specified post from storage.
     * @response 200 {
        "data": "success"
     * }
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $deleted = $repository->forceDelete($post);

        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}
