<?php

namespace App\Repositories\Eloquent;

use App\Models\AdminRole;
use App\Repositories\AdminRoleRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;
use Illuminate\Support\Facades\DB;

class AdminRoleRepositoryEloquent extends BaseRepositoryEloquent implements AdminRoleRepository
{
	/**
	 * Construct
	 *
	 * @param AdminRole $model
	 */
	public function __construct(AdminRole $model)
	{
		$this->model = $model;
	}

    /**
     * Get CMS Table
     */
    public function getCmsTable($requestData)
    {
        $datatables = $this->model->query();

        $datatables = $datatables->select([
            'admin_role.id',
            'admin_role.name',
            DB::raw('(
                SELECT
                COUNT(admin_users.id) as total
                FROM admin_users
                    JOIN admin_model_has_roles
                        ON admin_users.id = admin_model_has_roles.model_id
                    WHERE admin_model_has_roles.role_id = admin_role.id
            ) as total')
        ]);

        if (isset($requestData['keyword']))
            $datatables = $datatables->where('name', 'like', '%'.$requestData['keyword'].'%');

        $datatables = $datatables->paginate(10);
        $datatables = $datatables->toArray();

        return $datatables;
    }
}
