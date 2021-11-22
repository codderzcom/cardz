<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Domain\AggregateRootInterface;

trait DomainTestTrait
{
    protected function assertDomainEvent(AggregateRootInterface $aggregateRoot, string $eventClass): void
    {
        $events = $aggregateRoot->tapEvents();
        $hasEvent = false;
        foreach ($events as $event) {
            if ($event instanceof $eventClass) {
                $hasEvent = true;
                break;
            }
        }
        $this->assertTrue($hasEvent);
    }
}
