<?php

namespace Module\Media\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class MediaTest extends TestCase
{
    const ENDPOINT = '/api/media/';


    public function testUpload()
    {
        $filename = 'test.jpg';
        $file = UploadedFile::fake()->image($filename);
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => $file,
        ]);
        $resp->assertStatus(201);
        $data = $resp->json('data');
        $file = $data['directory'].'/'.$filename;
        Storage::disk($data['disk'])->assertExists($file);        
        // delete test file from disk
        Storage::disk($data['disk'])->delete($file);
    }

    public function testInvalidMimeType()
    {
        $filename = 'test.xxx';
        $file = UploadedFile::fake()->create($filename, 100, 'application/zip');
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => $file,
        ]);
        $resp->assertStatus(422);
    }

    public function testRequired()
    {
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => null,
        ]);
        $resp->assertStatus(422);        
    }


    public function testUploadSize()
    {
        $filename = 'test.jpg';
        $file = UploadedFile::fake()->create($filename, 2048, 'image/jpg');
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => $file,
        ]);
        $resp->assertStatus(422);
    }


    public function testDelete()
    {

        $data = $this->createFile();
        $resp = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$data['id']);
        $resp->assertSee(['message'=>'Media deleted']);
        $resp->assertStatus(200);            

    }


    protected function createFile()
    {
        $filename = 'test_uique.jpg';
        $file = UploadedFile::fake()->image($filename);
        $resp = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, [
            'file' => $file,
        ]);       
        $data = $resp->json('data');
        return $data; 
    }

}
