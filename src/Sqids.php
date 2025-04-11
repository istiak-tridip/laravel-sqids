<?php

declare(strict_types=1);

namespace Istiak\Sqids;

use Istiak\Sqids\Support\Config;
use Istiak\Sqids\Support\CustomSqids;

class Sqids
{
    protected string $alphabet;

    protected int $minLength;

    /**
     * @var string[]
     */
    protected array $blocklist;

    protected bool $canonicalIds;

    protected CustomSqids $sqids;

    public function __construct(?string $seed = null)
    {
        $this->minLength = Config::minLength();
        $this->blocklist = Config::blockList();
        $this->canonicalIds = Config::canonicalIds();
        $this->alphabet = app(Config::class)->shuffledAlphabet($seed);
    }

    protected function sqids(): CustomSqids
    {
        return $this->sqids ??= new CustomSqids(
            $this->alphabet,
            $this->minLength,
            $this->blocklist
        );
    }
}
