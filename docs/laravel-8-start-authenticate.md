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


## Configure user model for tymon/jwt-auth

implement `Tymon\JWTAuth\Contracts\JWTSubject`

More details [https://jwt-auth.readthedocs.io/en/develop/quick-start/](https://jwt-auth.readthedocs.io/en/develop/quick-start/)

## step 1. run migration


```bash
php artisan migrate

```

## step 2. make seeder to generate sample data,

```bash
php artisan make:seeder UserSeeder

php artisan db:seed --class=UserSeeder

```

php artisan make:Controller Api/Auth/LoginController
