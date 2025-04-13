<?php

declare(strict_types=1);

namespace Istiak\Sqids;

use Arr;
use Istiak\Sqids\Exceptions\SqidsException;
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

    protected bool $validateIds;

    protected CustomSqids $sqids;

    public function __construct(?string $seed = null)
    {
        $this->minLength = Config::minLength();
        $this->blocklist = Config::blockList();
        $this->validateIds = Config::validateIds();

        $this->alphabet = Config::shuffledAlphabet($seed);
    }

    public function encode(int $id): string
    {
        return $this->sqids()->encode([$id]);
    }

    /**
     * @throws SqidsException
     */
    public function decode(string $id): int
    {
        $decoded = Arr::first($this->sqids()->decode($id));

        if ($decoded === null) {
            throw new SqidsException('The given ID is invalid or could not be decoded.');
        }

        if ($this->validateIds && $id !== $this->encode($decoded)) {
            throw new SqidsException('The decoded ID is not valid. While it may decode to a valid number, re-encoding produces a different ID.');
        }

        return $decoded;
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
