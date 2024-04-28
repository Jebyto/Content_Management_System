<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function test_can_create_post()
    {
        $user = User::factory()->create();
        $postData = ['title' => $this->faker->sentence, 'content' => $this->faker->paragraph, 'user_id' => $user->id];

        $this->json('POST', route('/api/posts'), $postData)
            ->assertStatus(201)
            ->assertJson($postData);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();
        $postData = ['title' => $this->faker->sentence, 'content' => $this->faker->paragraph];

        $this->json('PUT', route('/api/posts', $post), $postData)
            ->assertStatus(200)
            ->assertJson($postData);
    }

    public function test_can_show_post()
    {
        $post = Post::factory()->create();

        $this->json('GET', route('/api/posts', $post))
            ->assertStatus(200);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();

        $this->json('DELETE', route('/api/posts', $post))
            ->assertStatus(204);
    }

    public function test_can_list_posts()
    {
        $posts = Post::factory()->count(3)->create();

        $this->json('GET', route('/api/posts'))
            ->assertStatus(200)
            ->assertJson($posts->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'title', 'user_id', 'content', 'created_at', 'updated_at'],
            ]);
    }

    public function test_can_show_posts_by_tag()
    {
        $tag = Tag::factory()->create();
        $posts = Post::factory()->count(3)->create();
        $tag->posts()->attach($posts);

        $this->json('GET', route('/api/posts/showByTag', $tag->name))
            ->assertStatus(200)
            ->assertJson($posts->toArray());
    }
}
