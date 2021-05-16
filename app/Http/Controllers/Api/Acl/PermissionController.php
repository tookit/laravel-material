<?php

namespace App\Http\Controllers\Api\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Permission as Model;
use App\Http\Resources\Acl\PermissionResource as Resource;
use App\Http\Requests\Acl\PermissionRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;



class PermissionController extends Controller
{
    /**
     * Display a listing of Roles.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->allowedFilters([
                'name'
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
     * create a new role.
     *
     * @param  \App\Http\Requests\Acl\PermissionRequest $request
     * @return \App\Http\Resources\Acl\PermissionResource
     */
    public function store(ValidateRequest $request): Resource
    {
        $data = $request->validated();
        $data['type'] = 'custom';
        $item = Model::create($data);
        $resoure = new Resource($item);
         return $resoure
            ->additional(
                 [
                     'meta' =>
                        [
                             'message' => 'Permission updated',
                        ]
                 ]
            );
    }

    /**
     * Display the specified user.
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
     * @param  \App\Http\Requests\Acl\PermissionRequest $request
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
                        'message' => 'Permission updated',
                    ]
                ]
            );
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Model::findOrFail($id);
        $item->delete();
        return new Resource($item);
    }
}
