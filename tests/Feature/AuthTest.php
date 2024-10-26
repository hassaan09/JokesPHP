<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertCount(1, User::all());
        $this->assertEquals('testuser@gmail.com', User::first()->email);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_login()
    {
        $user = User::create([
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    
        $response = $this->post('/login', [
            'email' => 'testuser@gmail.com',
            'password' => 'password123',
        ]);
    
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }
    /** @test */
    public function a_user_can_logout()
    {
        $user = User::create([
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Act as the user
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest(); // This should now pass
        $response->assertRedirect('/login');
    }

}
