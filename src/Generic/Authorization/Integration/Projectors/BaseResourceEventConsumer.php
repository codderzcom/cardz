<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Integration\Mappers\EventResourceMapperInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

abstract class BaseResourceEventConsumer implements IntegrationEventConsumerInterface
{
    protected ResourceRepositoryInterface $resourceRepository;

    protected EventResourceMapperInterface $mapper;

    public function handle(string $event): void
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }
        $resource = $this->mapper->map($event);
        $this->augmentAttributes($resource);
        $this->resourceRepository->persist($resource);
    }

    abstract protected function augmentAttributes(Resource $resource): void;
}
