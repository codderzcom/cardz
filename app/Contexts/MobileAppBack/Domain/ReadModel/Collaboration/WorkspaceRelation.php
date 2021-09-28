<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Collaboration;

class WorkspaceRelation
{
    public function __construct(
        public string $collaboratorId,
        public string $workspaceId,
        public string $relationType,
    ) {
    }
}
