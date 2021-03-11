<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class StorageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function listDir(Request $request)
    {

        $fs = Storage::disk('local');
        $dirs = collect($fs->listContents('media'))->sortBy('type');
        return new JsonResource($dirs);
    }

    public function listFile(Request $request)
    {

        $path = $request->get('path','/media');
        $fs = Storage::disk('local');
        $files = collect($fs->listContents($path))->sortBy('type');
        return new JsonResource($files);
    }

    }
