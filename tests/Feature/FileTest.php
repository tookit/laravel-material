<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FileTest extends TestCase
{
    const ENDPOINT = '/api/file/';


    public function testUpload()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => $file,
        ]);
        $resp->assertStatus(201);
        Storage::disk('public')->assertExists('avatar.jpg');        

    }

}
