<?php

declare(strict_types=1);

namespace Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Istiak\Sqids\Concerns\HasSqids;

class User extends Model
{
    use HasSqids;
}
