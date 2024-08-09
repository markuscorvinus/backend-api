<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase
{   
    use RefreshDatabase;

    public function setUp(): void
    {   
        parent::setUp();
        $user = User::factory()->make();
        $this->actingAs($user);
    }

    /**
     * A basic unit test example.
     */
    public function test_create_posts(): void
    {
        //1 define the goal
        //test if create will actually create a record in db
        

        //2 replicate the env
        $postService = $this->app->make(PostService::class);

        //3 define the source of truth
        $payload = [
            'title' => 'heyaa',
            'body' => [],
        ];
        $payload = json_decode(json_encode($payload));
        $result = $postService->createPosts($payload);

        //4 compare result
        $this->assertSame($payload->title, $result->title, 'Post create is mismatch');
    }

    public function test_update_posts(): void
    {
        //1 define the goal
        //test if update method will actually update the record in db

        //2 replicate the env
        $postService = $this->app->make(PostService::class);
        $dummyPost = Post::factory(1)->create()->first();

        //3 define the source of truth
        $newValue = [
            'title' => 'asoiaf book',
            'body' => ''
        ];
        $newValue = json_decode(json_encode($newValue));
        $result = $postService->updatePosts($dummyPost, $newValue);

        //4 compare result
        $this->assertSame($newValue->title, $result->title, 'Post update is mismatch');
    }

    public function test_delete_posts(): void
    {
        //1 define the goal
        //test if delete method will actually delete the record in db

        //2 replicate the env
        $postService = $this->app->make(PostService::class);
        $dummyPost = Post::factory(1)->create()->first();

        //3 define the source of truth
        $result = $postService->deletePosts($dummyPost);

        //4 compare result
        $found = Post::find($dummyPost->id);
        $this->assertSame(null, $found, 'Post not deleted');
    }
}
