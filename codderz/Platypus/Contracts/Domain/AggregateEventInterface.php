<?php

namespace Codderz\Platypus\Contracts\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;

interface AggregateEventInterface extends EventInterface
{
    public static function shortName(): string;

    public function stream(): GenericIdInterface;

    public function at(): Carbon;

    public function changeset(): array;

    public function in(EventAwareAggregateRootInterface $aggregateRoot): static;

}
