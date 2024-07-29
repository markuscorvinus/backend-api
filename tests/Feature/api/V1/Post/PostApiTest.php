<?php

namespace Tests\Feature\Api\V1\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        //load data in db
        $posts = Post::factory(10)->create();
        $postIds = $posts->map(fn ($post) => $post->id);

        //call index endpoint
        $response = $this->json('get', '/api/posts');

        //assert status
        $response->assertStatus(200);
        // verify records
        $data = $response->json('data');
        collect($data)->each(fn ($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));
    }

    public function test_show(): void
    {
        //load data in db
        $dummy = Post::factory()->create();


        //call index endpoint
        $response = $this->json('get', '/api/posts/' . $dummy->id);

        //assert status
        $result = $response->assertStatus(200)->json('data');
        // verify records
        $this->assertEquals(data_get($result, 'id'), $dummy->id, 'Response ID is not the same');
    }

    public function test_create(): void
    {
        //Event::fake();
        //load data in db
        $dummy = Post::factory()->make();


        //call index endpoint
        $response = $this->json('post', '/api/posts/', $dummy->toArray());

        //assert status
        $result = $response->assertStatus(201)->json('data');
        //Event::assertDispatched(PostCreated::class);

        // verify records
        $result = collect($result)->only(array_keys($dummy->getAttributes()));

        $result->each(function ($value, $field) use ($dummy) {
            $this->assertSame(data_get($dummy, $field), $value, 'Fillable is not the same');
        });
    }
}
