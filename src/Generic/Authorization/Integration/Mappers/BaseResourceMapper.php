<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Infrastructure\Exceptions\EventReconstructionException;

abstract class BaseResourceMapper implements EventResourceMapperInterface
{
    protected const RESOURCE_TYPE = ResourceType::NULL;

    protected const RESOURCE_ID_NAME = 'id';

    public function map(string $event): Resource
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            throw new EventReconstructionException("Missing payload");
        }
        return Resource::restore(
            $this->getResourceId($payload),
            $this->getResourceType(),
            $this->getAttributes($payload)
        );
    }

    protected function getResourceId(object $payload): string
    {
        return $payload->{static::RESOURCE_ID_NAME};
    }

    protected function getResourceType(): string
    {
        return static::RESOURCE_TYPE;
    }

    abstract protected function getAttributes(object $payload): array;
}
