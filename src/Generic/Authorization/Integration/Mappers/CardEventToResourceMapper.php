<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class CardEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::CARD;

    protected const RESOURCE_ID_NAME = Attribute::CARD_ID;

    protected function getAttributes(object $payload): array
    {
        return [
            Attribute::CARD_ID => $payload->cardId,
            Attribute::PLAN_ID => $payload->planId,
            Attribute::CUSTOMER_ID => $payload->customerId,
        ];
    }
}
