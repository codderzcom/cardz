<?php

namespace App\Shared\Contracts\Domain;

use Carbon\Carbon;

interface DomainEventInterface
{
    public static function of(AggregateRootInterface $aggregateRoot): static;

    public function when(): Carbon;

    public function with(): AggregateRootInterface;

}
