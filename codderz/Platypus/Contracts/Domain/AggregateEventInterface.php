<?php

namespace Codderz\Platypus\Contracts\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\GenericIdInterface;

interface AggregateEventInterface
{
    public static function shortName(): string;

    public function stream(): GenericIdInterface;

    public function at(): Carbon;

    public function changeset(): array;

    public function in(EventAwareAggregateRootInterface $aggregateRoot): static;

}
