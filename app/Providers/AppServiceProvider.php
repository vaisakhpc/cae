<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ParserService;
use App\Services\ParserServiceInterface;
use App\Services\PersisterServiceInterface;
use App\Services\PersisterService;
use App\Services\ReaderServiceInterface;
use App\Services\ReaderService;
use App\Services\LoggerInterface;
use App\Services\LoggerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ParserServiceInterface::class, ParserService::class);
        $this->app->bind(PersisterServiceInterface::class, PersisterService::class);
        $this->app->bind(ReaderServiceInterface::class, ReaderService::class);
        $this->app->bind(LoggerInterface::class, LoggerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
