<?php

declare(strict_types=1);

namespace Istiak\Sqids;

use Istiak\Sqids\Support\Config;
use Sqids\Sqids as BaseSqids;

class Sqids extends BaseSqids
{
    /**
     * @param  string[]  $blocklist
     */
    public function __construct(string $alphabet = self::DEFAULT_ALPHABET, int $minLength = self::DEFAULT_MIN_LENGTH, array $blocklist = self::DEFAULT_BLOCKLIST)
    {
        parent::__construct($alphabet, $minLength, $blocklist);

        /**
         * The base Sqids library automatically shuffles the provided alphabet.
         * However, since this implementation uses a pre-shuffled alphabet,
         * we override the default behavior and skip the re-shuffling.
         */
        $this->alphabet = $alphabet;
    }

    public static function createFromConfig(?string $seed = null): self
    {
        return new self(
            alphabet: app(Config::class)->shuffledAlphabet($seed),
            minLength: app(Config::class)->minLength(),
            blocklist: app(Config::class)->blockList(),
        );
    }
}
