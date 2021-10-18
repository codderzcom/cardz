<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;

class MemberAppService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private RelationRepositoryInterface $relationRepository,
    ) {
    }

    public function acceptInvite(string $memberId, string $workspaceId): RelationId
    {
        $member = $this->memberRepository->take(CollaboratorId::of($memberId), WorkspaceId::of($workspaceId));
        $relation = $member->acceptInvite();
        $this->relationRepository->persist($relation);
        return $relation->relationId;
    }

}
