<?php

namespace App\Repositories\Eloquent;

use App\Models\Buku;
use App\Models\RoleUser;
use App\Repositories\BukuRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;

class RoleRepositoryEloquent extends BaseRepositoryEloquent
{
	
	public function __construct(RoleUser $model)
	{
		$this->model = $model;
	}


    
}
