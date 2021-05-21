<?php

namespace Modules\PMS\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\PMS\Models\Project;
use Modules\PMS\Models\Task;

class TaskTest extends TestCase
{

    const ENDPOINT = '/api/pms/task/';

    public function testViewItem() 
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
        $item = Task::factory()->make()->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Task::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);
    }



    public function testUnique()
    {
        $item = $this->createUniqueItem();
        $data = Task::factory()->make(['name'=> $item->name])->toArray();
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


    /**
     * 
     */
    public function testDelete()
    {
        $items = Task::factory(3)->create();
        $ids = $items->pluck('id')->join(',');
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$ids);
        $response->assertSee(['message'=>'Task deleted']);
        $response->assertStatus(200);

    }


    protected function createUniqueItem()
    {
        return Task::factory()->create();
    }


}
