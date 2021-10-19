<?php

namespace App\Contexts\Collaboration\Domain\ReadModel;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class EnteredRelation
{
    public function __construct(
        public RelationId $relationId,
        public CollaboratorId $memberId,
        public WorkspaceId $workspaceId,
        public RelationType $relationType,
    ) {
    }

    public function isMemberRelation(): bool
    {
        return RelationType::MEMBER()->equals($this->relationType);
    }
}
