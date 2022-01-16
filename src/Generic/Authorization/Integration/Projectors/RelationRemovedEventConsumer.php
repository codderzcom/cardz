<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Support\Collaboration\Integration\Events\RelationRemoved;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

final class RelationRemovedEventConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
    ) {
    }

    public function consumes(): array
    {
        return [
            RelationRemoved::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            return;
        }

        $this->resourceRepository->remove($payload->relationId, ResourceType::RELATION());
    }

}
