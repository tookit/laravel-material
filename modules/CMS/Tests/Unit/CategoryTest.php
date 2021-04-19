<?php

namespace Modules\CMS\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\CMS\Models\Category;

class CategoryTest extends TestCase
{

    const ENDPOINT = '/api/cms/category/';

    public function testViewCategory() 
    {
        $item = $this->createUniqueCategory();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreateCategory()
    {
        $item = Category::factory()->make()->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateCategoryFailed()
    {
        $item = Category::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }

    public function testUniqueRule()
    {
        $item = $this->createUniqueCategory();
        $data = Category::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }


    public function testUpdateCategory()
    {
        $item = $this->createUniqueCategory();
        $data = $item->toArray();
        $data['name'] = 'test';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeleteCategory()
    {
        $item = $this->createUniqueCategory();
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete('/api/cms/category/'.$item->id);
        $response->assertSee(['message'=>'Category deleted']);
        $response->assertStatus(200);

    }


    protected function createUniqueCategory()
    {
        return Category::factory()->create();
    }


}
