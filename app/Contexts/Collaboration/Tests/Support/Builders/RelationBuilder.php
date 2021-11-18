<?php

namespace App\Contexts\Collaboration\Tests\Support\Builders;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class RelationBuilder extends BaseBuilder
{
    private string $relationId;

    private string $collaboratorId;

    private string $workspaceId;

    private string $relationType;

    private Carbon $established;

    public function build(): Relation
    {
        return Relation::restore(
            $this->relationId,
            $this->collaboratorId,
            $this->workspaceId,
            $this->relationType,
            $this->established,
        );
    }

    public function generate(): static
    {
        $this->relationId = RelationId::makeValue();
        $this->collaboratorId = CollaboratorId::makeValue();
        $this->workspaceId = WorkspaceId::makeValue();
        $this->relationType = RelationType::MEMBER;
        $this->established = Carbon::now();
        return $this;
    }
}
