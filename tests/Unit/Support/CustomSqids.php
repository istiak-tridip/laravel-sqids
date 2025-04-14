<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use Closure;
use Istiak\Sqids\Support\CustomSqids;
use Sqids\Sqids;

it('will not re-shuffle the alphabet', function () {
    $alphabet = str_shuffle(Sqids::DEFAULT_ALPHABET);

    $instance = new CustomSqids($alphabet);
    $getAlphabet = Closure::bind(fn () => $this->alphabet, $instance, CustomSqids::class);

    expect($getAlphabet())->toBe($alphabet);
});
