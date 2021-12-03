<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Integration\Mappers\RelationEventToResourceMapper;
use Cardz\Support\Collaboration\Integration\Events\RelationEstablished;

final class RelationEstablishedEventConsumer extends BaseResourceEventConsumer
{
    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        RelationEventToResourceMapper $mapper,
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->mapper = $mapper;
    }

    public function consumes(): array
    {
        return [
            RelationEstablished::class,
        ];
    }

}
