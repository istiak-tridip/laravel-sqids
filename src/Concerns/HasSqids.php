<?php

declare(strict_types=1);

namespace Istiak\Sqids\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Istiak\Sqids\Exceptions\SqidsException;
use Istiak\Sqids\Sqids;
use Istiak\Sqids\Support\Config;

trait HasSqids
{
    /**
     * @var Sqids[]
     */
    protected static array $sqids;

    protected function initializeHasSqids(): void
    {
        $this->makeHidden($this->getKeyName());

        $this->append($this->getRouteKeyName());
    }

    /**
     * @return Attribute<string,never>
     */
    protected function refid(): Attribute
    {
        return Attribute::get(fn () => $this->encodeModelKey());
    }

    public function getRouteKeyName(): string
    {
        return 'refid';
    }

    /**
     * @noinspection MissingParameterTypeDeclarationInspection
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): BuilderContract
    {
        if ($this->isSqidsRouteBinding($value, $field)) {
            $field = $this->getKeyName();
            $value = $this->sqids()->decodeOrNull($value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * @param  Builder<static>  $query
     */
    public function scopeWhereSqid(Builder $query, string $sqid): void
    {
        $id = $this->sqids()->decodeOrNull($sqid);

        $query->whereKey($id);
    }

    /**
     * @param  Builder<static>  $query
     * @param  Arrayable<array-key,string>|iterable<array-key,string>  $sqids
     */
    public function scopeWhereSqidIn(Builder $query, Arrayable|iterable $sqids): void
    {
        $ids = collect($sqids)
            // @phpstan-ignore-next-line
            ->map(fn (string $sqid) => $this->sqids()->decodeOrNull($sqid));

        $query->whereKey($ids);
    }

    /**
     * @throws SqidsException
     */
    protected function encodeModelKey(): string
    {
        $id = $this->getKey();

        if (! is_int($id)) {
            throw new SqidsException(sprintf(
                'The property [%s] on model [%s] must be an integer, [%s] given.',
                $this->getKeyName(), $this::class, gettype($id)
            ));
        }

        return $this->sqids()->encode($id);
    }

    /**
     * @phpstan-assert-if-true string $value
     */
    protected function isSqidsRouteBinding(mixed $value, ?string $field): bool
    {
        if (! is_string($value) || mb_strlen($value) < Config::minLength()) {
            return false;
        }

        return $field === null || $field === $this->getRouteKeyName();
    }

    public function sqids(): Sqids
    {
        return self::$sqids[$this::class]
            ??= new Sqids($this::class);
    }
}
