<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Closure;
use Illuminate\Routing\Route;
use Tests\TestCase;

use App\Models\Permission;
use App\Models\User;



class AclTest extends TestCase
{
    /**
     * A basic test for `/api/me`
     *
     * @return void
     */
    public function testAccessDenied()
    {


        $user = User::factory()->create(); // create random user
        $permission = Permission::updateOrCreate([
            'name' => 'user.list',
        ]);
        $user->givePermissionTo($permission);        
        $resp = $this->actingAs($user)->getJson('/api/acl/role');
        $resp->assertStatus(403);
        
    }

    // public function testAccessDenied()
    // {


    //     $user = User::factory()->create(); // create random user
    //     $permission = Permission::findByName('user.list');
    //     $user->givePermissionTo($permission);
    //     $resp = $this->actingAs($user)->getJson('/api/acl/role');
    //     $resp->assertStatus(403);
        
    // }    

    // public function testAccessAllow()
    // {

    //     $user = User::factory()->create(); // create random user
    //     $permission = Permission::findByName('user.list');
    //     $user->givePermissionTo($permission);
    //     $resp = $this->actingAs($user)->getJson('/api/acl/user');
    //     $resp->assertStatus(200);
        
    // }    

    // public function testWildcardPermission()
    // {
    //     $user = User::factory()->create(); // create random user
    //     $permission = Permission::updateOrCreate([
    //         'name' => 'user.*',
    //         'guard_name' => 'api',
    //     ]);
    //     $user->givePermissionTo($permission);
    //     $resp = $this->actingAs($user)->getJson('/api/acl/user');
    //     $resp->assertStatus(200);
        
    // }



}
