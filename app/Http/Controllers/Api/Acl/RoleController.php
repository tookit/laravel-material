<?php

namespace App\Http\Controllers\Api\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Role as Model;
use App\Models\Permission;
use App\Http\Resources\Acl\RoleResource as Resource;
use App\Http\Requests\Acl\RoleRequest as ValidateRequest;
use App\Http\Requests\Acl\PermissionAttachRequest;
use App\Http\Requests\Acl\UserAttachRequest;



class RoleController extends Controller
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
            ->with(['users','permissions'])
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
     * @param  \App\Http\Requests\Acl\RoleRequest $request
     * @return \App\Http\Resources\Acl\RoleResource
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
                             'message' => 'Role updated',
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
     * @param  \App\Http\Requests\Acl\RoleRequest $request
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
                        'message' => 'Role updated',
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


     /**
     * Attach Permission for specify role
     *
     * @param  int $id
     * @param  \App\Http\Requests\Acl\PermissionAttachRequest $request
     * @return \Illuminate\Http\Response
     */
    public function attachPermission(PermissionAttachRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $data = $request->validated();
        $permissions = Permission::find($data['ids']);
        $item->syncPermissions($permissions);
        return new Resource($item);
    }    

     /**
     * Attach users for specify role
     *
     * @param  int $id
     * @param  \App\Http\Requests\Acl\UserAttachRequest $request
     * @return \Illuminate\Http\Response
     */
    public function attachUser(UserAttachRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $data = $request->validated();
        $item->users()->sync($data['ids']);
        return new Resource($item);
    }     
}
