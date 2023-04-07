<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('database.default', 'pgsql');
    }

    /** @test */
    public function can_get_all_posts()
    {
        $posts = Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertOk();
        $response->assertJsonCount(5);
    }

    /** @test */
    public function can_create_a_post()
    {
        $postData = [
            'title' => 'Post 1',
            'content' => 'text text text',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201);
        $response->assertJsonFragment($postData);
    }

    /** @test */
    public function can_get_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/'.$post->id);

        $response->assertOk();
        $response->assertJsonFragment($post->toArray());
    }

    /** @test */
    public function can_update_a_post()
    {
        $post = Post::factory()->create();

        $updatedPostData = [
            'title' => 'Updated Post 1',
            'content' => 'Updated text text text',
        ];

        $response = $this->putJson('/api/posts/'.$post->id, $updatedPostData);

        $response->assertOk();
        $this->assertDatabaseHas('posts', $updatedPostData);
        $response->assertJsonFragment($updatedPostData);
    }

    /** @test */
    public function can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/posts/'.$post->id);

        $response->assertNoContent();
        $this->assertModelMissing($post);
    }
}
