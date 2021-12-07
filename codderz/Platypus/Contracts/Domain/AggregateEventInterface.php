<?php

namespace Codderz\Platypus\Contracts\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\GenericIdInterface;

interface AggregateEventInterface
{
    public function context(): string;

    public function channel(): string;

    public function stream(): GenericIdInterface;

    public function version(): int;

    public function changeset(): array;

    public function at(): Carbon;

    public static function shortName(): string;

    public function in(AggregateRootInterface $aggregateRoot): static;

}
