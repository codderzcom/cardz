<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class RelationEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::RELATION;

    protected const RESOURCE_ID_NAME = 'relationId';

    protected function getAttributes(object $payload): array
    {
        return [
            'collaboratorId' => $payload->collaboratorId,
            'workspaceId' => $payload->workspaceId,
        ];
    }
}
