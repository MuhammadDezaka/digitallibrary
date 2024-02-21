<?php

namespace App\Repositories\Eloquent;

use App\Models\Buku;
use App\Repositories\BukuRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;

class BukuRepositoryEloquent extends BaseRepositoryEloquent implements BukuRepository
{
	
	public function __construct(Buku $model)
	{
		$this->model = $model;
	}

	public function create($data)
	{
    	return $this->model->create($data);
	}

    
}
