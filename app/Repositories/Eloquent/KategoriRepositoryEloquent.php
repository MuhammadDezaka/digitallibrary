<?php

namespace App\Repositories\Eloquent;

use App\Models\Kategori;
use App\Repositories\KategoriRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;

class KategoriRepositoryEloquent extends BaseRepositoryEloquent implements KategoriRepository
{
	
	public function __construct(Kategori $model)
	{
		$this->model = $model;
	}

    
}
