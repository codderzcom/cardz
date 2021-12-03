<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class RelationEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::RELATION;

    protected const RESOURCE_ID_NAME = Attribute::RELATION_ID;

    protected function getAttributes(object $payload): array
    {
        return [
            Attribute::COLLABORATOR_ID => $payload->collaboratorId,
            Attribute::WORKSPACE_ID => $payload->workspaceId,
            Attribute::RELATION_TYPE => $payload->relationType,
        ];
    }
}
