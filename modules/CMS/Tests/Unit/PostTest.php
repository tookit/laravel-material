<?php

namespace Modules\CMS\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\CMS\Models\Post;

class PostTest extends TestCase
{

    public function testViewPost() 
    {
        $item = $this->createUniquePost();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson('/api/cms/post/'.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreatePost()
    {
        $item = Post::factory()->make()->toArray();
        $item['tags'] = ['test'];
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson('/api/cms/post', $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Post::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson('/api/cms/post', $item);
        $response->assertStatus(422);

    }

    public function testUniqueRule()
    {
        $item = $this->createUniquePost();
        $data = Post::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson('/api/cms/post', $data);
        $response->assertStatus(422);

    }


    public function testUpdatePost()
    {
        $item = $this->createUniquePost();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson('/api/cms/post/'.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeletePost()
    {
        $item = $this->createUniquePost();
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete('/api/cms/post/'.$item->id);
        $response->assertSee(['message'=>'Post deleted']);
        $response->assertStatus(200);

    }


    protected function createUniquePost()
    {
        return Post::factory()->create();
    }


}
