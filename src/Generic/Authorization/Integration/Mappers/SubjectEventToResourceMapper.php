<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class SubjectEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::SUBJECT;

    protected const RESOURCE_ID_NAME = Attribute::USER_ID;

    protected function getAttributes(object $payload): array
    {
        return [
            Attribute::SUBJECT_ID => $payload->userId,
        ];
    }
}
