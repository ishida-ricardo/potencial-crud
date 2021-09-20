<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\DeveloperRepositoryInterface;
use App\Repositories\Eloquent\DeveloperRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DeveloperRepositoryInterface::class, 
            DeveloperRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [
            DeveloperEloquentRepository::class,
        ];
    }
}
