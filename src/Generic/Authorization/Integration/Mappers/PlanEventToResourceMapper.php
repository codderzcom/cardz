<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class PlanEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::PLAN;

    protected const RESOURCE_ID_NAME = Attribute::PLAN_ID;

    protected function getAttributes(object $payload): array
    {
        return [
            Attribute::PLAN_ID => $payload->planId,
            Attribute::WORKSPACE_ID => $payload->workspaceId,
        ];
    }
}
