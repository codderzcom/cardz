<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class PlanEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::PLAN;

    protected const RESOURCE_ID_NAME = 'planId';

    protected function getAttributes(object $payload): array
    {
        return [
            'workspaceId' => $payload->workspaceId,
            'planId' => $payload->planId,
        ];
    }
}
