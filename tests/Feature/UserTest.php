<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User as Model;
use App\Models\Permission;


class UserTest extends TestCase
{
    const ENDPOINT = '/api/acl/user/';

    public function testViewItem() 
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreateItem()
    {
        $item = Model::factory()->make()->getAttributes();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Model::factory()->make(['username'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }

    public function testUniqueUsername()
    {
        $item = $this->createUniqueItem();
        $data = Model::factory()->make(['username'=> $item->name])->getAttributes();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }

    public function testUniqueEmail()
    {
        $item = $this->createUniqueItem();
        $data = Model::factory()->make(['email'=> $item->email])->getAttributes();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }




    public function testUpdateItem()
    {
        $item = $this->createUniqueItem();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeleteItem()
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$item->id);
        $response->assertStatus(200);

    }


    public function testAttachPermission()
    {

        $permissions = Permission::factory(2)->create();
        $data = ['ids'=>$permissions->pluck('id')->toArray()];
        $user = $this->createUniqueItem();
        $endpoint = self::ENDPOINT.$user->id.'/permission';
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson($endpoint, $data);
        $response->assertStatus(200);
        $this->assertEquals($user->hasAnyPermission($permissions), true);
    }




    protected function createUniqueItem()
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
