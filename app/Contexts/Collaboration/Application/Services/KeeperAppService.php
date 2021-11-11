<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInvite;
use App\Contexts\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class KeeperAppService
{
    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private RelationRepositoryInterface $relationRepository,
        private InviteRepositoryInterface $inviteRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function keepWorkspace(KeepWorkspace $command): RelationId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId(), $command->getWorkspaceId());
        $relation = $keeper->keep($command->getRelationId());
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }

    public function invite(ProposeInvite $command): InviteId
    {
        $keeper = $this->keeperRepository->take($command->getKeeperId(), $command->getWorkspaceId());
        $invite = $keeper->invite($command->getInviteId());
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }
}
