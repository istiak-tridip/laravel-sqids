<?php

declare(strict_types=1);

namespace Istiak\Sqids\Support;

use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;
use Sqids\Sqids;

class Config
{
    /**
     * @var array<string, string>
     */
    protected static array $shuffleCache = [];

    public static function shuffleSeed(): string
    {
        return config()->string(
            key: 'sqids.shuffle_seed',
            default: config()->string('app.key')
        );
    }

    public static function minLength(): int
    {
        return config()->integer(
            key: 'sqids.min_length',
            default: 10
        );
    }

    public static function validateIds(): bool
    {
        return config()->boolean(
            key: 'sqids.validate_ids',
            default: true
        );
    }

    /**
     * @return string[]
     */
    public static function blockList(): array
    {
        /** @var string[] */
        return config()->array(
            key: 'sqids.blocklist',
            default: Sqids::DEFAULT_BLOCKLIST
        );
    }

    public static function alphabet(): string
    {
        return config()->string(
            key: 'sqids.alphabet',
            default: Sqids::DEFAULT_ALPHABET
        );
    }

    public static function generateNumericIds(bool $condition = true): void
    {
        $condition && config()->set('sqids.alphabet', '0123456789');
    }

    public static function shuffledAlphabet(?string $seed = null): string
    {
        $seedHash = hash('sha256', ($seed ?? '').self::shuffleSeed());

        return static::$shuffleCache[$seedHash]
            ??= static::shuffleAlphabetUsingRandomizer($seedHash);
    }

    protected static function shuffleAlphabetUsingRandomizer(string $seedHash): string
    {
        $randomizer = new Randomizer(new Xoshiro256StarStar(
            seed: (string) hex2bin($seedHash),
        ));

        return $randomizer->shuffleBytes(self::alphabet());
    }
}
