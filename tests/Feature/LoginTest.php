<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        // create a user instance
        $user = \App\Models\User::factory()->create(
            [
                'password' => 'secret',
                'username' => 'tookit',
                'email'=>'wangqiangshen@gmail.com',
                'flag' => 1
            ]
        );
        $resp = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $resp->assertStatus(200);
        $resp->assertJsonStructure([
            'access_token',
            'expires_in'
        ]);
    }
}
