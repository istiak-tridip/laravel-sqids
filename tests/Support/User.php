<?php

declare(strict_types=1);

namespace Tests\Support;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Istiak\Sqids\Concerns\HasSqids;
use Orchestra\Testbench\Factories\UserFactory;

#[UseFactory(UserFactory::class)]
class User extends \Illuminate\Foundation\Auth\User
{
    /**
     * @use HasFactory<UserFactory>
     */
    use HasFactory;

    use HasSqids;

    protected $guarded = [];
}
