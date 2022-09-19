<?php

namespace Modules\Mall\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use Modules\Mall\Models\Category as Model;
use Modules\Mall\Transformers\Category as Resource;
use Modules\Mall\Http\Requests\CategoryRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Str;
use Modules\Mall\Http\Requests\AttachPropertyRequest;

class CategoryController extends Controller
{

    const RESOURCE = "Mall Category";

    /**
     * Display a listing of resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->allowedFilters([
                AllowedFilter::exact('flag'),
                'name',
            ]);

        return Resource::collection(

            $request->get('pageSize') !== '-1'
                ?
                $builder->paginate($request->get('pageSize'), ['*'], 'page')
                :
                $builder->get()

        );
    }

    /**
     * create a new resource.
     *
     * @param  ValidateRequest $request
     * @return Resource
     */
    public function store(ValidateRequest $request): Resource
    {
        $item = Model::create($request->validated());
        $resoure = new Resource($item);
        return $resoure
            ->additional(
                [
                    'meta' =>
                    [
                        'message' => sprintf('%s created', self::RESOURCE)
                    ]
                ]
            );
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  ValidateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $item->update($request->validated());
        $resource = new Resource($item);
        return $resource
            ->additional(
                [
                    'meta' =>
                    [
                        'message' => sprintf('%s updated', self::RESOURCE)
                    ]
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mix $ids
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $ids = Str::of($ids)->explode(',')->toArray();
        Model::whereIn('id', $ids)->delete();
        $resource = new Resource([]);
        return $resource
        ->additional(
            [
                'meta' =>
                [
                    'message' => sprintf('%s deleted', self::RESOURCE)
                ]
            ]
        );
    }

    /**
     * Attach Property for a category
     * {
     *   names: []
     * }
     *
     * @param  mix $id
     * @return \Illuminate\Http\Response
     */
    public function attachProperty($id, AttachPropertyRequest $request)
    {
        $item = Model::find($id);
        $data = $request->validated();
        $item->attachProperties($data['names']);
        $resource = new Resource($item);
        return $resource
        ->additional(
            [
                'meta' =>
                [
                    'message' => sprintf('%s propety attached', self::RESOURCE)
                ]
            ]
        );
    }
}
