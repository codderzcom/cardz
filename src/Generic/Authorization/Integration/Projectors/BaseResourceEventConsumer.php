<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Exceptions\EventReconstructionException;
use Cardz\Generic\Authorization\Integration\Mappers\EventResourceMapperInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

abstract class BaseResourceEventConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

    protected ResourceRepositoryInterface $resourceRepository;

    protected EventResourceMapperInterface $mapper;

    /**
     * @throws EventReconstructionException
     */
    public function handle(string $event): void
    {
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            throw new EventReconstructionException("Missing payload");
        }

        $resource = $this->mapper->map($payload);
        $resource->appendAttributes($this->getAdditionalAttributes($resource));
        $this->resourceRepository->persist($resource);
    }

    protected function getAdditionalAttributes(Resource $resource): array
    {
        // override when needed
        return [];
    }
}
