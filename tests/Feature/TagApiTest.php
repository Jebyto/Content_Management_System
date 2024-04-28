<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function test_can_create_tag()
    {
        $post = Post::factory()->create();
        $tagData = ['name' => $this->faker->word, 'post_id' => $post->id];

        $this->json('POST', route('/api/tags'), $tagData)
            ->assertStatus(201)
            ->assertJson($tagData);
    }

    public function test_can_update_tag()
    {
        $tag = Tag::factory()->create();
        $tagData = ['name' => $this->faker->word];

        $this->json('PUT', route('/api/tags', $tag), $tagData)
            ->assertStatus(200)
            ->assertJson($tagData);
    }

    public function test_can_show_tag()
    {
        $tag = Tag::factory()->create();

        $this->json('GET', route('/api/tags', $tag))
            ->assertStatus(200);
    }

    public function test_can_delete_tag()
    {
        $tag = Tag::factory()->create();

        $this->json('DELETE', route('/api/tags', $tag))
            ->assertStatus(204);
    }

    public function test_can_list_tags()
    {
        $tags = Tag::factory()->count(3)->create();

        $this->json('GET', route('/api/tags'))
            ->assertStatus(200)
            ->assertJson($tags->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'name', 'post_id', 'created_at', 'updated_at'],
            ]);
    }
}
