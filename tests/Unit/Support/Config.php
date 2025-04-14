<?php

declare(strict_types=1);

use Istiak\Sqids\Support\Config;

it('can get the `shuffle_seed` config', function () {
    // Assert the default
    expect(Config::shuffleSeed())->toBe(config('app.key'));

    // Assert config customization
    config()->set('sqids.shuffle_seed', $rand = Str::random());
    expect(Config::shuffleSeed())->toBe($rand);
});

it('can get the `min_length` config', function () {
    // Assert the default
    expect(Config::minLength())->toBe(10);

    // Assert config customization
    config()->set('sqids.min_length', $rand = rand(1, 100));
    expect(Config::minLength())->toBe($rand);
});

it('can get the `validate_ids` config', function () {
    // Assert the default
    expect(Config::validateIds())->toBeTrue();

    // Assert config customization
    config()->set('sqids.validate_ids', $rand = (bool) rand(0, 1));
    expect(Config::validateIds())->toBe($rand);
});

it('can get the `blocklist` config', function () {
    // Assert the default
    expect(Config::blocklist())->toBeArray();

    // Assert config customization
    config()->set('sqids.blocklist', $rand = [Str::random(), Str::random()]);
    expect(Config::blocklist())->toBe($rand);
});

it('can get the `alphabet` config', function () {
    // Assert the default
    expect(Config::alphabet())->toBeString();

    // Assert config customization
    config()->set('sqids.alphabet', $rand = Str::random());
    expect(Config::alphabet())->toBe($rand);
});

test('`generateNumericIds` changes the alphabet', function () {
    Config::generateNumericIds();

    expect(Config::alphabet())->toBe('0123456789');
});

it('can shuffle the configured `alphabet`', function () {
    $shuffled = Config::shuffledAlphabet();
    $shuffled2 = Config::shuffledAlphabet(Str::random());

    expect($shuffled)->not->toBe(Config::alphabet());
    expect($shuffled)->not->toBe($shuffled2);

    $shuffleCache = Closure::bind(fn () => Config::$shuffleCache, null, Config::class);
    expect($shuffleCache())->toBeArray();
    expect($shuffleCache())->not->toBeEmpty();
});
