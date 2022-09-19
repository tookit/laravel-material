<?php

namespace Modules\CMS\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\CMS\Models\Category;
use Modules\CMS\Models\Post;

class PostTest extends TestCase
{

    const ENDPOINT = '/api/cms/post/';

    public function testView() 
    {
        $item = $this->createUniquePost();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $category = $this->createCategory();
        $item = Post::factory()->make(['category_id' => $category->id])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Post::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }

    public function testUniqueRule()
    {
        $item = $this->createUniquePost();
        $data = Post::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }

    public function testUrlRule()
    {
        $data = Post::factory()->make(['featured_image'=> 'invalid url'])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }
    


    public function testUpdatePost()
    {
        $item = $this->createUniquePost();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeletePost()
    {
        $items = Post::factory(3)->create();
        $ids = $items->pluck('id')->join(',');
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$ids);
        $response->assertSee(['message'=>'Post deleted']);
        $response->assertStatus(200);

    }


    protected function createUniquePost()
    {
        return Post::factory()->create();
    }

    protected function createCategory()
    {
        return Category::factory()->create();
    }



}
