<?php

namespace Modules\Mall\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Mall\Models\Item;
use Modules\Mall\Models\Property;

class PropertyTest extends TestCase
{

    const ENDPOINT = '/api/mall/property/';

    public function testView() 
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
        $property = Property::factory()->make();
        $data = [
            'name' => $property->name,
            'values' => ['test']
        ];
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Property::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }



    public function testUniqueRule()
    {
        $item = $this->createUniqueItem();
        $data = Property::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
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
        $items = Item::factory(3)->create();
        $ids = $items->pluck('id')->join(',');
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$ids);
        $response->assertStatus(200);
    }


    protected function createUniqueItem()
    {
        return Property::factory()->create();
    }



}
