<?php

namespace Cardz\Support\Collaboration\Application\Services;

use Cardz\Support\Collaboration\Application\Commands\Invite\ProposeInvite;
use Cardz\Support\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

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
