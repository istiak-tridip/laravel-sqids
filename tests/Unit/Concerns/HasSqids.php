<?php

declare(strict_types=1);

use Istiak\Sqids\Exceptions\SqidsException;
use Tests\Support\User;

it('can generate Sqid from a model ID', function () {
    $model = User::make(['id' => 123]);

    expect($model->refid)
        ->toBeString()
        ->not->toBeEmpty();
});

it('can decode Sqid back to the model ID', function () {
    $model = User::make(['id' => $rand = rand()]);

    expect($model->sqids()->decode($model->refid))->toBe($rand);
});

it('will throw exception when model ID is not an integer', function () {
    expect(fn () => User::make()->toArray())
        ->toThrow(SqidsException::class);
});

it('can handle route binding', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->get(route('users.show', $user))
        ->assertContent($user->email);

    $this->get(route('users.show', $user->id))
        ->assertNotFound();

    $this->get(route('users.show', 'invalid'))
        ->assertNotFound();

    $this->get(route('users.details', $user->id))
        ->assertContent($user->email);

});

it('can find a model using `whereSqid` scope', function () {
    /** @var User $model */
    $model = User::factory()->create();

    $result = User::query()->whereSqid($model->refid)->first();

    expect($result->id)->toBe($model->id);
});

it('can find a model using `whereSqidIn` scope', function () {
    /** @var Collection<int, User> $models */
    $models = User::factory()->count(2)->create();

    $result = User::query()
        ->whereSqidIn($models->pluck('refid'))
        ->get();

    expect($result->pluck('id')->toArray())
        ->toBe($models->pluck('id')->toArray());
});
