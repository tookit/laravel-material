<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

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

    public function logRequest($uri,$method, $payload, $resp)
    {

        $data = [
            'url' => $uri,
            'method' => $method,
            'payload' => $payload,
            'resp' => json_decode($resp->content())
        ];
        $contents = json_encode($data);

        return Storage::put('explore/resp.json',$contents);        

    }
}
