<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function makeAdmin(){


        return  \App\Models\User::updateOrCreate(

            ['email' => config('admin.email')],

            [
                'username' => config('admin.username'),
                'email' => config('admin.email'),
                'password' => config('admin.password'),
                'active'=>1
            ]);
    }
}
