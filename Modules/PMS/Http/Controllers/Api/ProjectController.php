<?php

namespace Modules\PMS\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PMS\Enum\ProjectStatus;
use Spatie\QueryBuilder\QueryBuilder;

use Modules\PMS\Models\Project as Model;
use Modules\PMS\Transformers\Project as Resource;
use Modules\PMS\Http\Requests\ProjectRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;



class ProjectController extends Controller
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
                        'message' => 'Project created',
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

    public function getStatus()
    {
        return new Resource(ProjectStatus::asSelectArray());
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
                        'message' => 'Project updated',
                    ]
                ]
            );
    }

    /**
     * Remove the specified Project from storage.
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
                    'message' => 'Project deleted',
                ]
            ]
        );
    }
}
