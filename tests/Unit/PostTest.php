<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_post()
    {
        $user = User::factory()->create();
        $post = new Post(['title' => 'Test Post', 'content' => 'Test Content', 'user_id' => $user->id]);

        $this->assertEquals('Test Post', $post->title);
        $this->assertEquals('Test Content', $post->content);
        $this->assertEquals($user->id, $post->user_id);
    }

    /**
     * Test the update of a Post.
     *
     * @return void
     */
    public function test_update_post()
    {
        $post = Post::factory()->create();
        $post->title = 'Updated Post';
        $post->content = 'Updated Content';

        $this->assertEquals('Updated Post', $post->title);
        $this->assertEquals('Updated Content', $post->content);
    }
}
