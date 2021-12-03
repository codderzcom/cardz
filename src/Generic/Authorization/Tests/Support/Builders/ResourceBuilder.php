<?php

namespace Cardz\Generic\Authorization\Tests\Support\Builders;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class ResourceBuilder extends BaseBuilder
{
    public string $resourceId;

    public string $resourceType;

    public array $attributes;

    public function build(): Resource
    {
        return Resource::restore(
            $this->resourceId,
            $this->resourceType,
            $this->attributes,
        );
    }

    public function buildSubject(string $subjectId): Resource
    {
        $this->resourceId = $subjectId;
        $this->resourceType = ResourceType::SUBJECT;
        $this->attributes = [Attribute::SUBJECT_ID => $subjectId];
        return $this->build();
    }

    public function buildWorkspace(string $workspaceId, string $keeperId): Resource
    {
        $this->resourceId = $workspaceId;
        $this->resourceType = ResourceType::WORKSPACE;
        $this->attributes = [
            Attribute::WORKSPACE_ID => $workspaceId,
            Attribute::KEEPER_ID => $keeperId,
        ];
        return $this->build();
    }

    public function buildPlan(string $planId, string $workspaceId, string $keeperId): Resource
    {
        $this->resourceId = $planId;
        $this->resourceType = ResourceType::PLAN;
        $this->attributes = [
            Attribute::PLAN_ID => $planId,
            Attribute::WORKSPACE_ID => $workspaceId,
            Attribute::KEEPER_ID => $keeperId,
        ];
        return $this->build();
    }

    public function buildCard(string $cardId, string $customerId, string $planId, string $workspaceId, string $keeperId): Resource
    {
        $this->resourceId = $cardId;
        $this->resourceType = ResourceType::CARD;
        $this->attributes = [
            Attribute::CARD_ID => $cardId,
            Attribute::CUSTOMER_ID => $customerId,
            Attribute::PLAN_ID => $planId,
            Attribute::WORKSPACE_ID => $workspaceId,
            Attribute::KEEPER_ID => $keeperId,
        ];
        return $this->build();
    }

    public function buildRelation(string $collaboratorId, string $workspaceId, string $relationType): Resource
    {
        $this->resourceId = GuidBasedImmutableId::makeValue();
        $this->resourceType = ResourceType::RELATION;
        $this->attributes = [
            Attribute::COLLABORATOR_ID => $collaboratorId,
            Attribute::WORKSPACE_ID => $workspaceId,
            Attribute::RELATION_TYPE => $relationType,
        ];
        return $this->build();
    }

    public function withResourceId(string $resourceId): self
    {
        $this->resourceId = $resourceId;
        return $this;
    }

    public function withResourceType(string $resourceType): self
    {
        $this->resourceType = $resourceType;
        return $this;
    }

    public function withAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function generate(): static
    {
        $this->resourceId = GuidBasedImmutableId::makeValue();
        $this->resourceType = ResourceType::NULL;
        $this->attributes = [];
        return $this;
    }
}
