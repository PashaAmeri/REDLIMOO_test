<?php

namespace App\Providers;

use App\Services\OtpService;
use App\Services\PostsService;
use App\Services\UsersService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\OtpServiceInterface;
use App\Interfaces\Services\PostsServiceInterface;
use App\Interfaces\Services\UsersServiceInterface;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(UsersServiceInterface::class, UsersService::class);
        $this->app->bind(OtpServiceInterface::class, OtpService::class);
        $this->app->bind(PostsServiceInterface::class, PostsService::class);
    }
}
