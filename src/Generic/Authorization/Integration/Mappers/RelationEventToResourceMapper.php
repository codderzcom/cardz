<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use JetBrains\PhpStorm\ArrayShape;

class RelationEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::RELATION;

    protected const RESOURCE_ID_NAME = Attribute::RELATION_ID;

    #[ArrayShape([Attribute::COLLABORATOR_ID => "string", Attribute::WORKSPACE_ID => "string", Attribute::RELATION_TYPE => "string"])]
    protected function getAttributes(object $eventPayload): array
    {
        return [
            Attribute::COLLABORATOR_ID => $eventPayload->collaboratorId,
            Attribute::WORKSPACE_ID => $eventPayload->workspaceId,
            Attribute::RELATION_TYPE => $eventPayload->relationType,
        ];
    }
}
