<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

abstract class BaseResourceMapper implements EventResourceMapperInterface
{
    protected const RESOURCE_TYPE = ResourceType::NULL;

    protected const RESOURCE_ID_NAME = 'id';

    public function map(object $eventPayload): Resource
    {
        return Resource::restore(
            $this->getResourceId($eventPayload),
            $this->getResourceType(),
            $this->getAttributes($eventPayload)
        );
    }

    protected function getResourceId(object $eventPayload): string
    {
        return $eventPayload->{static::RESOURCE_ID_NAME};
    }

    protected function getResourceType(): string
    {
        return static::RESOURCE_TYPE;
    }

    abstract protected function getAttributes(object $eventPayload): array;
}
