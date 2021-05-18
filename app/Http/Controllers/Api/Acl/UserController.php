<?php

namespace App\Http\Controllers\Api\Acl;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\User as Model;
use App\Http\Resources\Acl\UserResource as Resource;
use App\Http\Requests\Acl\UserRequest as ValidateRequest;
use App\Http\Requests\Acl\PermissionAttachRequest;
use App\Http\Requests\Acl\RoleAssignRequest;
use App\Models\Permission;
use App\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;



class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->with(['roles'])
            ->allowedFilters([
                AllowedFilter::callback('flag', function (Builder $query, $value) {
                    $query->where('flag', '=', Model::getFlagValue($value));
                }),
                AllowedFilter::exact('gender'),
                'username',
            ]);

        return Resource::collection(

            $request->get('pageSize') !== '-1'
                ?
                $builder->paginate($request->get('pageSize'), ['*'], 'page')
                :
                $builder->get()

        );
    }

    public function getProfile()
    {
        $me = Auth::guard('api')->user();
        return new Resource($me);

    }


    public function updateProfile()
    {
        $me = Auth::guard('api')->user();
        return new Resource($me);
    }


    /**
     * create a new user.
     *
     * @param  \App\Http\Requests\Acl\UserRequest $request
     * @return \App\Http\Resources\Acl\UserResource
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
                             'message' => 'User updated',
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
     * @param  \App\Http\Requests\Acl\UserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateRequest $request, $id)
    {
        $data = $request->validated();
        $item = Model::findOrFail($id);
        $item->update($data);
        if($request->get('role_ids')) {
            $item->syncRoles($data['role_ids']);
        }
        $resource = new Resource($item);
        return $resource
            ->additional(
                [
                    'meta' =>
                    [
                        'message' => 'User updated',
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
     * Attach Permission for a Role.
     *
     * @param  int $id
     * @param  \App\Http\Requests\Acl\PermissionAttachRequest $request
     * @return \Illuminate\Http\Response
     */
    public function attachPermission(PermissionAttachRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $ids = $request->validated();
        $permissions = Permission::find($ids);
        $item->syncPermissions($permissions);
        return new Resource($item);
    }

     /**
     * Assign roles for a user.
     *
     * @param  int $id
     * @param  \App\Http\Requests\Acl\RoleAssignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function assignRole(RoleAssignRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $data = $request->validated();
        $roles = Role::find($data['ids']);
        $item->syncRoles($roles);
        return new Resource($item);
    }

}
