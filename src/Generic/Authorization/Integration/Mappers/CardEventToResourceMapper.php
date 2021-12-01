<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class CardEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::CARD;

    protected const RESOURCE_ID_NAME = 'cardId';

    protected function getAttributes(object $payload): array
    {
        return [
            'cardId' => $payload->cardId,
            'planId' => $payload->planId,
        ];
    }
}
