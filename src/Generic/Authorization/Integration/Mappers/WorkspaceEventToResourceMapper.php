<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class WorkspaceEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::WORKSPACE;

    protected const RESOURCE_ID_NAME = 'workspaceId';

    protected function getAttributes(object $payload): array
    {
        return [
            'workspaceId' => $payload->workspaceId,
            'keeperId' => $payload->keeperId,
        ];
    }
}
