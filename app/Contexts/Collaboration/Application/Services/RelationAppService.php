<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelationCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class RelationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function acceptInvite(AcceptInviteCommandInterface $command): RelationId
    {
        //ToDo: нарушение рекомендации 1 агрегат на 1 команду.

        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->accept($command->getCollaboratorId());

        $relation = $invite->establishRelation($command->getRelationId(), $command->getCollaboratorId());
        $this->relationRepository->persist($relation);

        $this->domainEventBus->publish(...$invite->releaseEvents(), ...$relation->releaseEvents());
        return $relation->relationId;
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
