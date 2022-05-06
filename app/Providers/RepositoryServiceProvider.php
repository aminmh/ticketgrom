<?php

namespace App\Providers;

use App\Infrastructure\Contracts\DepartmentRepositoryInterface;
use App\Repositories\DB\DepartmentRepository;
use Modules\Setting\Contracts\SettingRepositoryInterface;
use Modules\Setting\Repository\SettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
