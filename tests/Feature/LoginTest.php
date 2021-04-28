<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Auth Test.
     *
     * @return void
     */
    public function testLogin()
    {
        // create a user instance
        $uri = '/api/auth/login';
        $user = $this->createUniqueUser();
        $payload =  [
            'email' => $user->email,
            'password' => 'secret'
        ];
        $resp = $this->post($uri,$payload);
        $resp->assertStatus(JsonResponse::HTTP_OK);
        $resp->assertJsonStructure([
            'access_token',
            'expires_in'
        ]);
        $this->logRequest($uri, 'post',$payload, $resp);
    }

    public function testLoginFailed()
    {
        $user = $this->createUniqueUser();
        $resp = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'ｗrong password'
        ]);
        $resp->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

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
