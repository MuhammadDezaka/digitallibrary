<?php

namespace App\Repositories\Eloquent;

use App\Models\KoleksiBuku;
use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Repositories\KoleksiRepository;

class KoleksiRepositoryEloquent extends BaseRepositoryEloquent implements KoleksiRepository
{
	
	public function __construct(KoleksiBuku $model)
	{
		$this->model = $model;
	}

    
}
