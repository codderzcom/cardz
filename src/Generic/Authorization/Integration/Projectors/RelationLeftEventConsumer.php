<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Support\Collaboration\Integration\Events\RelationLeft;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class RelationLeftEventConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
    ) {
    }

    public function consumes(): array
    {
        return [
            RelationLeft::class,
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
