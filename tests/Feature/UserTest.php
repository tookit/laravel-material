<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test for `/api/me`
     *
     * @return void
     */
    public function testMe()
    {
        $user  = $this->createUniqueUser();
        $response = $this->actingAs($user)->get('/api/me');
        $response->assertStatus(200);
        $response->assertSee('tookit_test');
    }

    protected function createUniqueUser()
    {
        return \App\Models\User::factory()->create(
            [
                'password' => 'secret',
                'username' => 'tookit_test', // make name unique
                'flag' => 1
            ]
        );
    }
}
