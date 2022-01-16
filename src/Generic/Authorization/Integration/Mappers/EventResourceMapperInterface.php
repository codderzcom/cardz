<?php

namespace Cardz\Generic\Authorization\Integration\Mappers;

use Cardz\Generic\Authorization\Domain\Resource\Resource;

interface EventResourceMapperInterface
{
    public function map(object $eventPayload): Resource;
}
