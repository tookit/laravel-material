<?php

namespace Modules\Mall\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Mall\Models\Brand;

class BrandTest extends TestCase
{

    const ENDPOINT = '/api/mall/brand/';

    public function testList() 
    {
        Brand::factory(3)->create();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT);
        $response->assertStatus(200);
    }

    public function testViewSingle() 
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $item = Brand::factory()->make()->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Brand::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }

    public function testUniqueRule()
    {
        $item = $this->createUniqueItem();
        $data = Brand::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }


    public function testUrlRule()
    {
        $item = Brand::factory()->make(['url' => 'invalid url']);
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item->toArray());
        $response->assertStatus(422);

    }


    public function testUpdate()
    {
        $item = $this->createUniqueItem();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDelete()
    {
        $items = Brand::factory(3)->create();
        $ids = $items->pluck('id')->join(',');
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$ids);
        $response->assertStatus(200);

    }


    protected function createUniqueItem()
    {
        return Brand::factory()->create();
    }


}
