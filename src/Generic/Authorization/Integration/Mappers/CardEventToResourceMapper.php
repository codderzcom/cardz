<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use JetBrains\PhpStorm\ArrayShape;

class CardEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::CARD;

    protected const RESOURCE_ID_NAME = Attribute::CARD_ID;

    #[ArrayShape([Attribute::CARD_ID => "string", Attribute::PLAN_ID => "string", Attribute::CUSTOMER_ID => "string"])]
    protected function getAttributes(object $eventPayload): array
    {
        return [
            Attribute::CARD_ID => $eventPayload->cardId,
            Attribute::PLAN_ID => $eventPayload->planId,
            Attribute::CUSTOMER_ID => $eventPayload->customerId,
        ];
    }
}
