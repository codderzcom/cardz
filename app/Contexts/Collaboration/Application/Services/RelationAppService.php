<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Relation\EstablishRelationCommandInterface;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelationCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class RelationAppService
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function establish(EstablishRelationCommandInterface $command): RelationId
    {
        $relation = Relation::establish(
            $command->getRelationId(),
            $command->getCollaboratorId(),
            $command->getWorkspaceId(),
            $command->getRelationType()
        );
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $command->getRelationId();
    }

    public function leave(LeaveRelationCommandInterface $command): RelationId
    {
        $relation = $this->relationRepository->find($command->getCollaboratorId(), $command->getWorkspaceId());
        $relation->leave();
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }
}
