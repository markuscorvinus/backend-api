<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request['page_no'] ?? 10;
        $comments = Comment::query()->paginate($perPage);
        return new JsonResponse(['data' => $comments]);
        //return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::query()->create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'body' => $request->body
        ]);

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
    public function update(Request $request, Comment $comment)
    {
        $updated = $comment->update([
            'body' => $request->body ?? $comment->body,
        ]);
        // $post->title = $request->title;
        // $post->body = $request->body;
        // $post->save();
        if (!$updated) {
            return new JsonResponse(['data' => 'failed'], 400);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();
        if (!$deleted) {
            return new JsonResponse(['data' => 'failed'], 400);
        }
        return new JsonResponse(['data' => $deleted]);
    }
}
