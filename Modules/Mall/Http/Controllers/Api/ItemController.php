<?php

namespace Modules\Mall\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Mall\Http\Requests\AttachValueRequest;
use Modules\Mall\Http\Requests\DetailRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Modules\Mall\Models\Item as Model;
use Modules\Mall\Transformers\Item as Resource;
use Modules\Mall\Http\Requests\ItemRequest as ValidateRequest;
use Modules\Mall\Models\Property;
use Spatie\QueryBuilder\AllowedFilter;



class ItemController extends Controller
{

    const RESOURCE = "Mall Item";

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
                AllowedFilter::exact('status'),
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
     * Update the specified resource in storage.
     *
     * @param  DetailRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetail(DetailRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $data = $request->validated();
        if($item->detail) {
            $item->detail()->save($data);
        }else {
            $item->detail()->create($data);
        }
        $resource = new Resource($item);
        return $resource
            ->additional(
                [
                    'meta' =>
                    [
                        'message' => sprintf('%s detail saved', self::RESOURCE)
                    ]
                ]
            );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  mix $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $item = Model::find($ids);
        $item->delete();
        $resource = new Resource($item);
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
     * Attach Property for a item
     * {
     *   name: ''
     *   values: []
     * }
     *
     * @param  mix $id
     * @return \Illuminate\Http\Response
     */
    public function attachValue($id, AttachValueRequest $request)
    {
        $item = Model::find($id);
        $data = $request->validated();
        $propetyName = Property::findOrCreate($data['name']);
        $values = $propetyName->attachValue($data['values']);
        $item->properties()->saveMany($values);
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
