<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Comment::query()->get();
        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'body' => $request['body'],
        ]);

        return new JsonResponse([
            'data'=> $comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data'=> $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $updated = $comment->update([
            'body' => $request->body ?? $comment->body,
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
            'data'=> $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();

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
