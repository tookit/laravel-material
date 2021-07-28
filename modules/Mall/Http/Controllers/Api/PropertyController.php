<?php

namespace Modules\Mall\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Mall\Models\Property as Model;
use Modules\Mall\Transformers\Property as Resource;
use Modules\Mall\Http\Requests\PropertyRequest as ValidateRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Str;


class PropertyController extends Controller
{

    const RESOURCE = "Mall Property";

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
        $data = $request->validated();
        $propertyName = Model::create($data);

        if($request->get('values')) {
            $propertyName->attachValues($request->get('values'));
        }

        $resoure = new Resource($propertyName);
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
        $propertyName = Model::findOrFail($id);
        if($request->get('values')) {
            $propertyName->attachValues($request->get('values'));
        }
        $resource = new Resource($propertyName);
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
     * @param  mix $id
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
}
