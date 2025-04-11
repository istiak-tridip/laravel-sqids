<?php

declare(strict_types=1);

namespace Istiak\Sqids\Support;

use Istiak\Sqids\Sqids;
use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;

class Config
{
    /**
     * @var array<string, string>
     */
    protected array $shuffleCache = [];

    public function shuffleSeed(): string
    {
        return config()->string(
            key: 'sqids.shuffle_seed',
            default: config()->string('app.key')
        );
    }

    public function minLength(): int
    {
        return config()->integer(
            key: 'sqids.min_length',
            default: Sqids::DEFAULT_MIN_LENGTH
        );
    }

    public function canonicalIds(): bool
    {
        return config()->boolean(
            key: 'sqids.canonical_ids',
            default: true
        );
    }

    /**
     * @return string[]
     */
    public function blockList(): array
    {
        /** @var string[] */
        return config()->array(
            key: 'sqids.blocklist',
            default: Sqids::DEFAULT_BLOCKLIST
        );
    }

    public function alphabet(): string
    {
        return config()->string(
            key: 'sqids.alphabet',
            default: Sqids::DEFAULT_ALPHABET
        );
    }

    public function shuffledAlphabet(?string $seed = null): string
    {
        $seedHash = hash('sha256', ($seed ?? '').$this->shuffleSeed());

        return $this->shuffleCache[$seedHash]
            ??= $this->shuffleAlphabetUsingRandomizer($seedHash);
    }

    protected function shuffleAlphabetUsingRandomizer(string $seedHash): string
    {
        $randomizer = new Randomizer(new Xoshiro256StarStar(
            seed: (string) hex2bin($seedHash),
        ));

        return $randomizer->shuffleBytes($this->alphabet());
    }
}
