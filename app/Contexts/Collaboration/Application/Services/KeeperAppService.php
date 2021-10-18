<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInviteCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class KeeperAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private RelationRepositoryInterface $relationRepository,
        private InviteRepositoryInterface $inviteRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function bindWorkspace(string $keeperId, string $workspaceId): RelationId
    {
        $keeper = $this->keeperRepository->take(CollaboratorId::of($keeperId), WorkspaceId::of($workspaceId));
        $relation = $keeper->keepWorkspace();
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }

    public function invite(ProposeInviteCommandInterface $command): InviteId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId(), $command->getWorkspaceId());
        $invite = $keeper->invite($command->getMemberId());
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }
}
