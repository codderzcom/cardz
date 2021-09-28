<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class MemberAppService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private RelationRepositoryInterface $relationRepository,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function acceptInvite(string $memberId, string $workspaceId): ServiceResultInterface
    {
        $member = $this->memberRepository->take(CollaboratorId::of($memberId), WorkspaceId::of($workspaceId));
        if ($member === null) {
            return $this->serviceResultFactory->violation("Collaborator $memberId is not invited to the workspace $workspaceId");
        }

        $relation = $member->acceptInvite();
        $relation->enter(RelationType::MEMBER());
        $this->relationRepository->persist($relation);
        return $this->serviceResultFactory->ok($relation->relationId);
    }

}
