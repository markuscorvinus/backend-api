<?php

namespace App\Services\Post;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function allPosts($attributes)
    {
        $perPage = $attributes['page_no'] ?? 10;
        $posts = Post::query()->paginate($perPage);

        return $posts;
    }

    public function createPosts($attributes)
    {

        return DB::transaction(function () use ($attributes) {
            $posts = Post::query()->create([
                'title' => $attributes->title,
                'body' => $attributes->body
            ]);
            if (!$posts) {
                throw new GeneralJsonException('No post record created', 404);
            }

            throw_if(!$posts, GeneralJsonException::class, 'No post record created');
            if (property_exists($attributes, 'user_id')) {
                $posts->users()->sync($attributes->user_id);
            }
            return $posts;
        });
    }

    public function updatePosts($post, $attributes)
    {
        $updated = $post->update([
            'title' => $attributes->title ?? $post->title,
            'body' => $attributes->body ?? $post->body,
        ]);

        if (!$updated) {
            throw new GeneralJsonException('No post record update', 400);
        }

        return $post;
    }

    public function deletePosts($post)
    {
        $deleted = $post->forceDelete();
        return $deleted;
    }
}
