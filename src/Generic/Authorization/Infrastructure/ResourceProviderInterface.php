<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Domain\Attribute\Attributes;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Contracts\GeneralIdInterface;

interface ResourceProviderInterface
{
    public function getResourceAttributes(?GeneralIdInterface $resourceId, ResourceType $resourceType): Attributes;
}
