<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_tag()
    {
        $post = Post::factory()->create();
        $tag = new Tag(['name' => 'Test Tag', 'post_id' => $post->id]);

        $this->assertEquals('Test Tag', $tag->name);
        $this->assertEquals($post->id, $tag->post_id);
    }

    /**
     * Test the update of a Tag.
     *
     * @return void
     */
    public function test_update_tag()
    {
        $tag = Tag::factory()->create();
        $tag->name = 'Updated Tag';

        $this->assertEquals('Updated Tag', $tag->name);
    }
}
