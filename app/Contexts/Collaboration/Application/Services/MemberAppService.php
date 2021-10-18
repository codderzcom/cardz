<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class MemberAppService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private RelationRepositoryInterface $relationRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function acceptInvite(AcceptInviteCommandInterface $command): RelationId
    {
        //ToDO: strange... InviteId?
        $member = $this->memberRepository->take($command->getMemberId(), $command->getWorkspaceId());
        $relation = $member->acceptInvite();
        $this->relationRepository->persist($relation);
        $this->domainEventBus->publish(...$relation->releaseEvents());
        return $relation->relationId;
    }

}
