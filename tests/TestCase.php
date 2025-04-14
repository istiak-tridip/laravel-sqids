<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Istiak\Sqids\SqidsServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Support\User;

#[WithMigration]
#[WithEnv('AUTH_MODEL', User::class)]
class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            SqidsServiceProvider::class,
        ];
    }

    protected function defineWebRoutes($router): void
    {
        $callback = function (User $record) {
            return $record->email;
        };

        $router->get('/users/{record}', $callback)->name('users.show');
        $router->get('/users/{record:id}/details', $callback)->name('users.details');
    }
}
