<?php

namespace Modules\PMS\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\PMS\Models\Project;

class ProjectTest extends TestCase
{

    const ENDPOINT = '/api/pms/project/';

    public function testViewPoject() 
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreateProject()
    {
        $item = Project::factory()->make()->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Project::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }

    public function testUniqueRule()
    {
        $item = $this->createUniqueItem();
        $data = Project::factory()->make(['name'=> $item->name])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $data);
        $response->assertStatus(422);

    }


    public function testUpdateProject()
    {
        $item = $this->createUniqueItem();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeleteProject()
    {
        $items = Project::factory(3)->create();
        $ids = $items->pluck('id')->join(',');
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$ids);
        $response->assertSee(['message'=>'Project deleted']);
        $response->assertStatus(200);

    }


    protected function createUniqueItem()
    {
        return Project::factory()->create();
    }


}
