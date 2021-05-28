<?php

namespace Module\Media\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use Module\Media\Models\Media as Model;
use Module\Media\Http\Resources\MediaResource as Resource;
use Module\Media\Http\Requests\MediaRequest as ValidateRequest;
use Module\Media\Http\Requests\DirectoryRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of files.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('disk'),
                AllowedFilter::exact('aggregate_type')
            ]);

        return Resource::collection(

            $request->get('pageSize') !== '-1'
                ?
                $builder->paginate($request->get('pageSize'), ['*'], 'page')
                :
                $builder->get()

        );
    }


    public function createDirectory(DirectoryRequest $request)
    {
        $data = $request->validated();
        Storage::disk('public')->makeDirectory($data['path']);
        $resoure = new Resource([]);
        return $resoure
           ->additional(
                [
                    'meta' =>
                       [
                           'message' => 'Directory created',
                       ]
                ]
           );        
    }

    public function getDirectory()
    {
        return new Resource(Model::getDirectory());
    }


    public function getTypes()
    {

        $collection = collect(config('mediable.aggregate_types'));
        return new Resource($collection);

    }


    /**
     * Display the specified Media.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): Resource
    {
        $item = Model::findOrFail($id);
        return new Resource($item);
    }


    /**
     * create a new file.
     *
     * @param  \App\Http\Requests\Media\FileRequest $request
     * @return \App\Http\Resources\Media\FileResource 
     */
    public function store(ValidateRequest $request): Resource
    {
        $data = $request->validated();
        $uploader = MediaUploader::fromSource($data['file']);
        $aggrationType = $uploader->inferAggregateType($data['file']->getClientMimeType(), $data['file']->getClientOriginalExtension());
        $disk = $request->get('disk','public');
        $directory = $request->get('directory', $aggrationType);
        $item = MediaUploader::fromSource($data['file'])
            ->toDisk($disk)
            ->toDirectory($directory)
            // pass the callable
            ->upload();
        $resoure = new Resource($item);
         return $resoure
            ->additional(
                 [
                     'meta' =>
                        [
                            'message' => 'File uploaded',
                        ]
                 ]
            );
    }

    /**
     *
     * @param  \App\Http\Requests\Media\FileRequest $request
     * @return \Illuminate\Http\UploadedFile
     */
    public function getUploadFile(ValidateRequest $request) {



    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $items = Model::find($ids);
        $items->delete();
        $resource = new Resource([]);
        return $resource
        ->additional(
            [
                'meta' =>
                [
                    'message' => 'Media deleted',
                ]
            ]
        );
    }    

 
}
