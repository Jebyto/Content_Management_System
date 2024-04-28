<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $userData = ['name' => 'Test User', 'email' => 'test@example.com', 'password' => Hash::make('password')];
        $user = new User($userData);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /**
     * Test the update of a User.
     *
     * @return void
     */
    public function test_update_user()
    {
        $user = User::factory()->create();
        $user->name = 'Updated User';
        $user->email = 'updated@example.com';

        $this->assertEquals('Updated User', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
    }
}
