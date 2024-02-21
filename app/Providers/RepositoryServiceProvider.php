<?php

namespace App\Providers;

use App\Repositories\BukuRepository;
use App\Repositories\Eloquent\BukuRepositoryEloquent;
use App\Repositories\Eloquent\KategoriRepositoryEloquent;
use App\Repositories\Eloquent\KoleksiRepositoryEloquent;
use App\Repositories\Eloquent\PeminjamanRepositoryEloquent;
use App\Repositories\Eloquent\UlasanRepositoryEloquent;
use App\Repositories\KategoriRepository;
use App\Repositories\KoleksiRepository;
use App\Repositories\PeminjamanRepository;
use App\Repositories\UlasanRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BukuRepository::class, BukuRepositoryEloquent::class);
        $this->app->bind(KategoriRepository::class, KategoriRepositoryEloquent::class);
        $this->app->bind(PeminjamanRepository::class, PeminjamanRepositoryEloquent::class);
        $this->app->bind(UlasanRepository::class, UlasanRepositoryEloquent::class);
        $this->app->bind(KoleksiRepository::class, KoleksiRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
