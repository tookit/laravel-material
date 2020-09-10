# Authentication

Base my personal experience, I prefer test driven development by laravel. Before we started diving into codeing, I need to prepare two things

- Configure phpunit test
- prepare the data schema

## create my first test

```bash
    php artisan make:test LoginTest
```

## Let's write the test as we expected

``` php

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test login to get access token.
     *
     * @return void
     */
    public function testLogin()
    {
        // create a user instance
        $user = factory(\App\Models\User::class)->create(['password' => 'secret', 'username' => 'tookit','email'=>'wangqiangshen@gmail.com','flag' => 1]);
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

```

## Review the test code,  we need to prepare something first

- The User Model/Migration
- The User Model factory definition
- The API end point `/api/auth/login`
