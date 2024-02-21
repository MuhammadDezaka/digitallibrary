<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleUserRequest;
use App\Repositories\Eloquent\RoleRepositoryEloquent;

class RoleController extends Controller
{

    protected $configrepo;

    public function __construct(RoleRepositoryEloquent $repo)
    {
        $this->configrepo = $repo;
        // $this->middleware('admin_pusaka');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.role.index');
    }

    public function tables(Request $request) {
        $relasi = ['permissions'];

        $where = [];
        return $this->configrepo->getCmsTableWhere($relasi, $where);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleUserRequest $request)
    {
        $request = $request->validated();
        $store = $this->configrepo->create($request);
        return ['status' => 'success'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUserRequest $request)
    {
        $request = $request->validated();
        $update = $this->configrepo->update($request['id'], $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $this->configrepo->find($request->id);
        if (is_null($data)) {
            abort(404);
        }

        $this->configrepo->delete($request->id);
        return ['status' => 'success'];
    }

    public function getRolePermissions($roleId)
    {
        $role = RoleUser::find($roleId);
        $permissions = Permission::all();

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        $permissionsData = $permissions->map(function ($permission) use ($rolePermissions) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'checked' => in_array($permission->id, $rolePermissions),
            ];
        });

        return ['permissions' => $permissionsData];
    }

    public function updatePerms(Request $request, $roleId)
    {
        // Get the role by its ID
        $role = Role::find($roleId);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $permissions = $request->input('permissions', []);

        // dd($request);

        try {
            $role->syncPermissions($permissions);
        } catch (\Exception $e) {
        
            return response()->json(['message' => 'Error syncing permissions'], 500);
        }

        return response()->json(['message' => 'Permissions updated successfully']);
    }


}
