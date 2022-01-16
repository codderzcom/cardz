<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use JetBrains\PhpStorm\ArrayShape;

class SubjectEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::SUBJECT;

    protected const RESOURCE_ID_NAME = Attribute::USER_ID;

    #[ArrayShape([Attribute::SUBJECT_ID => "string"])]
    protected function getAttributes(object $eventPayload): array
    {
        return [
            Attribute::SUBJECT_ID => $eventPayload->userId,
        ];
    }
}
