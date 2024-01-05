<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * * GET api/comments?page=2&page_size=10
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;

        $comments = Comment::query()->paginate($pageSize);
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CommentRepository $repository)
    {
        $comment = $repository->create($request->only([
            'body',
            'user_id',
            'post_id',
        ]));

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment, CommentRepository $repository)
    {
        $comment = $repository->update($comment, $request->only([
            'body' 
        ]));

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, CommentRepository $repository)
    {
        $deleted = $repository->forceDelete($comment);
        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}
