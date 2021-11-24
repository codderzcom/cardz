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
    public string $relationId;

    public string $collaboratorId;

    public string $workspaceId;

    public string $relationType;

    public Carbon $established;

    public ?Carbon $left = null;

    public function build(): Relation
    {
        return Relation::restore(
            $this->relationId,
            $this->collaboratorId,
            $this->workspaceId,
            $this->relationType,
            $this->established,
            $this->left,
        );
    }

    public function buildForKeeper(): Relation
    {
        $this->relationType = RelationType::KEEPER;
        return Relation::restore(
            $this->relationId,
            $this->collaboratorId,
            $this->workspaceId,
            $this->relationType,
            $this->established,
            $this->left,
        );
    }

    public function withKeeperId(string $keeperId): self
    {
        $this->collaboratorId = $keeperId;
        $this->relationType = RelationType::KEEPER;
        return $this;
    }

    public function withCollaboratorId(string $collaboratorId): self
    {
        $this->collaboratorId = $collaboratorId;
        $this->relationType = RelationType::MEMBER;
        return $this;
    }

    public function withWorkspaceId(string $workspaceId): self
    {
        $this->workspaceId = $workspaceId;
        return $this;
    }

    public function generate(): static
    {
        $this->relationId = RelationId::makeValue();
        $this->collaboratorId = CollaboratorId::makeValue();
        $this->workspaceId = WorkspaceId::makeValue();
        $this->relationType = RelationType::MEMBER;
        $this->established = Carbon::now();
        $this->left = null;
        return $this;
    }
}
