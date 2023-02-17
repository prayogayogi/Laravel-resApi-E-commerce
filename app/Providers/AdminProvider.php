<?php

namespace App\Providers;

use App\Interfaces\Api\AuthInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Admin\AdminInterface;
use App\Interfaces\Admin\CategoryInterface;
use App\Interfaces\Admin\DashboardInterface;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\DashboardRepository;

class AdminProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(DashboardInterface::class, DashboardRepository::class);
    }
}
