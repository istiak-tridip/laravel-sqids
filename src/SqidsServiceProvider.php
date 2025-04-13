<?php

declare(strict_types=1);

namespace Istiak\Sqids;

use Illuminate\Support\ServiceProvider;

class SqidsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Sqids::class, fn () => new Sqids);

        $this->mergeConfigFrom(__DIR__.'/../config/sqids.php', key: 'sqids');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sqids.php' => config_path('sqids.php'),
        ], 'sqids-config');
    }
}
