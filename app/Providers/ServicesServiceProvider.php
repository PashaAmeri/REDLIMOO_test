<?php

namespace App\Providers;

use App\Services\UsersService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\UsersServiceInterface;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(UsersServiceInterface::class, UsersService::class);
    }
}
