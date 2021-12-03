<?php

namespace Codderz\Platypus\Contracts\Domain;

use Carbon\Carbon;

interface DomainEventInterface
{
    public static function of(AggregateRootInterface $aggregateRoot): static;

    public function at(): Carbon;

    public function with(): AggregateRootInterface;

}
