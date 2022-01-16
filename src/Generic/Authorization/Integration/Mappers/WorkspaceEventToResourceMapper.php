<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use JetBrains\PhpStorm\ArrayShape;

class WorkspaceEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::WORKSPACE;

    protected const RESOURCE_ID_NAME = Attribute::WORKSPACE_ID;

    #[ArrayShape([Attribute::WORKSPACE_ID => "string", Attribute::KEEPER_ID => "string"])]
    protected function getAttributes(object $eventPayload): array
    {
        return [
            Attribute::WORKSPACE_ID => $eventPayload->workspaceId,
            Attribute::KEEPER_ID => $eventPayload->keeperId,
        ];
    }
}
