<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     * 
     * @return PostResource
     */
    public function index(PostService $postService, Request $request)
    {
        $post = $postService->allPosts($request);
        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StorePostRequest $request
     * @return PostResource
     */
    public function store(PostService $postService, StorePostRequest $request)
    {
        Validator::make()->validateString('test', 123);
        $posts = $postService->createPosts($request);
        return new PostResource($posts);
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
    public function update(Post $post, Request $request, PostService $postService)
    {
        $post = $postService->updatePosts($post, $request);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostService $postService)
    {
        $deleted = $postService->deletePosts($post);

        if (!$deleted) {
            return new JsonResponse(['data' => 'failed'], 400);
        }
        return new JsonResponse(['data' => $deleted]);
    }

    /**
     * Share the specified resource in storage.
     */
    public function share(Post $post, Request $request, PostService $postService)
    {
        $url = URL::temporarySignedRoute('shared.post', now()->addDays(30), ['post' => $post->id]);

        return new HttpJsonResponse([
            'data' => $url
        ]);
    }
}
