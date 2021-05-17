<?php

namespace Modules\CMS\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use Modules\CMS\Models\Category as Model;
use Modules\CMS\Transformers\Category as Resource;
use Modules\CMS\Http\Requests\CategoryRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;



class CategoryController extends Controller
{
    /**
     * Display a listing of resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->allowedSorts(['created_at', 'name','id'])
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
        $item = Model::create($request->validated());
        $resoure = new Resource($item);
        return $resoure
            ->additional(
                [
                    'meta' =>
                    [
                        'message' => 'Category created',
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
                        'message' => 'Category updated',
                    ]
                ]
            );
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  mix int $ids || string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $items = Model::find($ids);
        $items->delete();
        $resource = new Resource($items);
        return $resource
        ->additional(
            [
                'meta' =>
                [
                    'message' => 'Category deleted',
                ]
            ]
        );
    }
   
}
