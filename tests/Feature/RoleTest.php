<?php

namespace Tests\Feature;

use App\Models\Role as Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;
use App\Models\User;

class RoleTest extends TestCase
{
    const ENDPOINT = '/api/acl/role/';

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
        $item = Model::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
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

    public function testAttachUser()
    {

        $users = User::factory(2)->create();
        $data = ['ids'=>$users->pluck('id')->toArray()];
        $role = $this->createUniqueItem();
        $endpoint = self::ENDPOINT.$role->id.'/user';
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson($endpoint, $data);
        $response->assertStatus(200);
        $this->assertEquals($role->users->pluck('id')->toArray(),$data['ids']);
    }


    public function testAttachPermission()
    {

        $permissions = Permission::factory(2)->create();
        $data = ['ids'=>$permissions->pluck('id')->toArray()];
        $role = $this->createUniqueItem();
        $endpoint = self::ENDPOINT.$role->id.'/permission';
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson($endpoint, $data);
        $response->assertStatus(200);
        $this->assertEquals($role->hasAnyPermission($permissions),true);
    }


    protected function createUniqueItem()
    {
        return Model::factory()->create(
            [
                'name' => 'role_test',
                'guard_name' => 'api', 
            ]
        );
    }
}
