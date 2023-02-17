<?php

namespace App\Providers;

use App\Interfaces\Api\AuthInterface;
use App\Repositories\Api\AuthRepository;
use Illuminate\Support\ServiceProvider;

class ApiProveder extends ServiceProvider
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
        $this->app->singleton(AuthInterface::class, AuthRepository::class);
    }
}
