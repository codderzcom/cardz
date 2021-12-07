<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Domain\Attribute\Attributes;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Contracts\GenericIdInterface;

interface ResourceProviderInterface
{
    public function getResourceAttributes(?GenericIdInterface $resourceId, ResourceType $resourceType): Attributes;
}
