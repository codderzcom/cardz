<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelationCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class RelationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function leave(LeaveRelationCommandInterface $command): RelationId
    {
        $relation = $this->relationRepository->take($command->getRelationId());
        $relation->leave();
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }
}
