<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AclTest extends TestCase
{
    /**
     * A basic test for `/api/me`
     *
     * @return void
     */
    public function testPermission()
    {
        $user = User::factory()->create();


        $permission = Permission::findByName('user.list');


        $user->givePermissionTo($permission);

        $resp = $this->actingAs($user)->getJson('/api/acl/user');

        $resp->assertStatus(200);
        
    }

}
