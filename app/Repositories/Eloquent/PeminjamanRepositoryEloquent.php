<?php

namespace App\Repositories\Eloquent;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Repositories\PeminjamanRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;

class PeminjamanRepositoryEloquent extends BaseRepositoryEloquent implements PeminjamanRepository
{
	
	public function __construct(Peminjaman $model)
	{
		$this->model = $model;
	}

    
}
