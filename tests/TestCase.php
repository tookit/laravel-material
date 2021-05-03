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

    public function logRequest($uri,$method, $payload, $resp, $status=200)
    {

        $file = 'explore/response.json';
        $data = [
            'url' => $uri,
            'method' => $method,
            'payload' => $payload,
            'status' => $status,
            'resp' => json_decode($resp->content())
        ];

        
        if(Storage::exists($file)) {
            $collection = collect(json_decode(Storage::get($file)));
            $find = $collection->search(function($item) use ($data) {
                return $item->url === $data['url'] && $item->method === $data['method'] && $item->status === $data['status'];
            });
            if($find) {
                $find = $data;
            }else {
                $collection->push($data);
            }

        }else {
            $collection = collect([]);
            $collection->push($data);

        }

        $contents = json_encode($collection->toArray());
        return Storage::put($file,$contents);        

    }
}
