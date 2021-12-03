<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class WorkspaceEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::WORKSPACE;

    protected const RESOURCE_ID_NAME = Attribute::WORKSPACE_ID;

    protected function getAttributes(object $payload): array
    {
        return [
            Attribute::WORKSPACE_ID => $payload->workspaceId,
            Attribute::KEEPER_ID => $payload->keeperId,
        ];
    }
}
