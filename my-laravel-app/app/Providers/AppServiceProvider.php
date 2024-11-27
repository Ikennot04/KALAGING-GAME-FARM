<?php

namespace App\Providers;

use App\Domain\Bird\BirdRepository;
use App\Infrastructure\Bird\EloquentBirdRepository;
use App\Domain\Worker\WorkerRepository;
use App\Infrastructure\Worker\EloquentWorkerRepository;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BirdRepository::class, EloquentBirdRepository::class);
        $this->app->bind(WorkerRepository::class, EloquentWorkerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
