<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\CollaboratorRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class CollaboratorAppService
{
    public function __construct(
        private CollaboratorRepositoryInterface $collaboratorRepository,
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function acceptInvite(AcceptInviteCommandInterface $command): RelationId
    {
        //ToDO: strange... InviteId?
        $member = $this->collaboratorRepository->take($command->getCollaboratorId());
        $relation = $member->collaborate($command->getWorkspaceId());
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }

}
