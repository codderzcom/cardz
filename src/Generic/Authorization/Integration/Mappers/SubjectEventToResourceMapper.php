<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class SubjectEventToResourceMapper extends BaseResourceMapper
{
    protected const RESOURCE_TYPE = ResourceType::SUBJECT;

    protected const RESOURCE_ID_NAME = 'userId';

    protected function getAttributes(object $payload): array
    {
        return [
            'subjectId' => $payload->userId,
        ];
    }
}
