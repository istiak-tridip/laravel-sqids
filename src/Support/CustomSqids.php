<?php

declare(strict_types=1);

namespace Istiak\Sqids\Support;

use Sqids\Sqids;

class CustomSqids extends Sqids
{
    /**
     * @param  string[]  $blocklist
     */
    public function __construct(string $alphabet = self::DEFAULT_ALPHABET, int $minLength = self::DEFAULT_MIN_LENGTH, array $blocklist = self::DEFAULT_BLOCKLIST)
    {
        parent::__construct($alphabet, $minLength, $blocklist);

        /**
         * The base Sqids library automatically shuffles the provided alphabet.
         * However, since this package always uses a pre-shuffled alphabet,
         * we override the default behavior and skip the re-shuffling.
         */
        $this->alphabet = $alphabet;
    }
}
