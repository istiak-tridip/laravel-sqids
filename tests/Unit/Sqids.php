<?php

declare(strict_types=1);

use Istiak\Sqids\Exceptions\SqidsException;
use Istiak\Sqids\Sqids;

it('can generate Sqid from integer', function () {
    // print sqlite tables

    $sqids = new Sqids;
    $encoded = $sqids->encode(123);

    expect($encoded)
        ->toBeString()
        ->not->toBeEmpty();
});

it('can decode a Sqid to the original integer', function () {
    $sqids = new Sqids;
    $decoded = $sqids->decode(
        $sqids->encode($id = rand())
    );

    expect($decoded)->toBe($id);
});

it('will throw exception when decoding fails', function () {
    $sqids = new Sqids;

    expect(fn () => $sqids->decode('@invalid'))
        ->toThrow(SqidsException::class, 'The given ID is invalid or could not be decoded.');

    expect(fn () => $sqids->decode('invalid'))
        ->toThrow(SqidsException::class, 'The decoded ID is not valid. While it may decode to a valid number, re-encoding produces a different ID.');
});

it('can use custom seed to generate consistent Sqids', function () {
    $seed = Str::random();
    $sqids1 = new Sqids($seed);
    $sqids2 = new Sqids($seed);

    $id = rand();
    $encoded1 = $sqids1->encode($id);
    $encoded2 = $sqids2->encode($id);

    expect($encoded1)->toBe($encoded2);
});

it('can use different seeds to generate unique Sqids', function () {
    $sqids1 = new Sqids(Str::random());
    $sqids2 = new Sqids(Str::random());

    $id = rand();
    $encoded1 = $sqids1->encode($id);
    $encoded2 = $sqids2->encode($id);

    expect($encoded1)->not->toBe($encoded2);
});
