<?php

namespace App\Repositories\Eloquent;

use App\Models\Kategori;
use App\Models\UlasanBuku;
use App\Repositories\KategoriRepository;
use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Repositories\UlasanRepository;

class UlasanRepositoryEloquent extends BaseRepositoryEloquent implements UlasanRepository
{
	
	public function __construct(UlasanBuku $model)
	{
		$this->model = $model;
	}

    
}
