<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Services\AdminUserService;
use App\Repositories\AdminUserRepository;
use App\Http\Requests\Admin\AdminUser\StorePemateriRequest;
use App\Http\Requests\Admin\AdminUser\StoreRequest;
use App\Http\Requests\Admin\AdminUser\UpdateRequest;
use App\Http\Requests\Admin\AdminUser\DeleteRequest;
use App\Http\Requests\Admin\AdminUser\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $adminUserService;
    protected $adminUserRepository;

    /**
     * Construct
     */
    public function __construct(
        AdminUserService $adminUserService,
        AdminUserRepository $adminUserRepository)
    {
        // $this->middleware('IsSuperAdmin');
        // $this->middleware('CheckPermission:admin_user');
        $this->adminUserService = $adminUserService;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * Index
     */
    public function index()
    {
        return view('admin::modules.admin-user.index');
    }

    /**
     * Tables
     */
    public function tables(Request $request)
    {
        $requestData['keyword'] = $request->keyword;

        return $this->adminUserRepository->getCmsTables($requestData);
    }

    /**
     * Store
     */
    public function store(StoreRequest $request)
    {
        createLogs('Create Admin Users');
        $request = $request->validated();

        // Get Detail Role
        $role = \Facades\App\Repositories\AdminRoleRepository::find($request['role_id']);

        // Add to Request
        $request['role'] = $role['name'];
        $request['password'] = Hash::make($request['password']);

        $user = $this->adminUserService->create($request);

        if($user && isset($request['sekolah_id'])){
            $this->adminUserService->updateSchool($user['id'], $request['sekolah_id']);
        }

        return ['status' => 'success'];
    }

    /**
     * Update
     */
    public function update(UpdateRequest $request)
    {
        createLogs('Update Admin Users');
        $request = $request->validated();
        // Get Detail Role
        $role = \Facades\App\Repositories\AdminRoleRepository::find($request['role_id']);
        // Check Role User
        $user = AdminUser::find($request['id']);

        if ( ! $user->hasRole($role['name'])) {
            $currentRole = $user->roles->first();
            if ($currentRole) {
                $user->removeRole($currentRole->name);
            }

            $user->assignRole($role['name']);
        }

        unset($request['role_id']);

        $this->adminUserRepository->update($request['id'], $request);

        if($user && isset($request['sekolah_id'])){
            $this->adminUserService->updateSchool($user['id'], $request['sekolah_id']);
        }

        return ['status' => 'success'];
    }

    /**
     * Delete
     */
    public function delete(DeleteRequest $request)
    {
        $request = $request->validated();
        // Find User
        $user = AdminUser::find($request['id']);
        // Delete Roles
        if ($user->roles) {
            foreach ($user->roles as $role) {
                $user->removeRole($role->name);
            }
        }
        // Delete User
        $user->delete();

        return ['status' => 'success'];
    }

    /**
     * Search Pemateri
     */
    public function searchPemateri(Request $request)
    {
        $request['keyword'] = $request->keyword;

        return $this->adminUserRepository->searchPemateri($request);
    }

    /**
     * Change Password
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $request = $request->validated();
        $request['password'] = Hash::make($request['password']);
        $this->adminUserService->update($request['id'], $request);
        return ['status' => 'success'];
    }

    /**
     * Store Pemateri
     */
    public function storePemateri(StorePemateriRequest $request)
    {
        $request = $request->validated();

        $request['password'] = Hash::make($request['username']);
        $request['role'] = 'Pemateri';

        return $this->adminUserService->create($request);
    }

    public function updateSekolahPengawas(Request $request)
    {

        if(Auth::user() && isset($request['sekolah_id'])){
            $this->adminUserService->updateSchool(Auth::user()->id, $request['sekolah_id']);
        }

        return ['status' => 'success'];
    }
}
