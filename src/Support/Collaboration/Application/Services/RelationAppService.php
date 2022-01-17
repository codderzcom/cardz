<?php

namespace Cardz\Support\Collaboration\Application\Services;

use Cardz\Support\Collaboration\Application\Commands\Relation\EstablishRelation;
use Cardz\Support\Collaboration\Application\Commands\Relation\RemoveRelation;
use Cardz\Support\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class RelationAppService
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function establish(EstablishRelation $command): RelationId
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

    /**
     * @throws RelationNotFoundExceptionInterface
     */
    public function remove(RemoveRelation $command): RelationId
    {
        $relation = $this->relationRepository->find($command->getCollaboratorId(), $command->getWorkspaceId());
        $relation->remove();
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }
}
