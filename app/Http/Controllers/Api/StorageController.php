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

        $dir = $request->get('dir','/');
        $fs = Storage::disk('oss');
        $dirs = $fs->allDirectories($dir, true);
        return new JsonResource($dirs);
    }

    public function listFile(Request $request)
    {

        $dir = $request->get('dir','/');
        $fs = Storage::disk('oss');
        $files = $fs->allFiles($dir, true);
        return new JsonResource($files);
    }
}
