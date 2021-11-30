<?php

namespace Codderz\Platypus\Infrastructure\Tests;

use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;

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
