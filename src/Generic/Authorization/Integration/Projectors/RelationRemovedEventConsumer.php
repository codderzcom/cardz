<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Support\Collaboration\Integration\Events\RelationRemoved;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class RelationRemovedEventConsumer implements IntegrationEventConsumerInterface
{
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
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }

        $this->resourceRepository->remove($payload->relationId, ResourceType::RELATION());
    }

}
