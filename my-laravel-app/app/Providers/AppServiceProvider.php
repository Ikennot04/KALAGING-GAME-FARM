<?php

namespace App\Providers;

use App\Domain\Bird\BirdRepository;
use App\Infrastructure\Bird\EloquentBirdRepository;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BirdRepository::class, EloquentBirdRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
