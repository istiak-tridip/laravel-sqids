<?php

declare(strict_types=1);

namespace Tests;

use Istiak\Sqids\SqidsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SqidsServiceProvider::class,
        ];
    }
}
