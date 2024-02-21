<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SekolahProfileRequest;
use App\Repositories\Eloquent\SekolahRepositoryEloquent;
use App\Helpers\HelperFile;
use App\Http\Requests\Admin\AdminUser\ChangePasswordRequest;
use App\Repositories\AdminUserRepository;
use App\Services\AdminUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ChangePasswordController extends Controller
{
    protected $configrepo;
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
        $this->adminUserService = $adminUserService;
        $this->adminUserRepository = $adminUserRepository;
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
}
