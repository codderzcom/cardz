<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use JetBrains\PhpStorm\ArrayShape;

class PlanEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::PLAN;

    protected const RESOURCE_ID_NAME = Attribute::PLAN_ID;

    #[ArrayShape([Attribute::PLAN_ID => "string", Attribute::WORKSPACE_ID => "string"])]
    protected function getAttributes(object $eventPayload): array
    {
        return [
            Attribute::PLAN_ID => $eventPayload->planId,
            Attribute::WORKSPACE_ID => $eventPayload->workspaceId,
        ];
    }
}
