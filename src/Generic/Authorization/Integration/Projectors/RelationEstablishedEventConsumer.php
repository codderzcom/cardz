<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use App\Models\Resource;
use Cardz\Generic\Authorization\Domain\Exceptions\ResourceNotFoundExceptionInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Infrastructure\Exceptions\ResourceNotFoundException;
use Cardz\Support\Collaboration\Integration\Events\RelationEstablished;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class RelationEstablishedEventConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
    ) {
    }

    public function consumes(): array
    {
        return [
            RelationEstablished::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }

        try {
            $workspace = $this->resourceRepository->find($payload->workspaceId, ResourceType::WORKSPACE());
            $memberIds = $workspace->memberIds ?? [];
            $memberIds[] = $payload->collaboratorId;
            $workspace->appendAttributes([
                'memberIds' => $memberIds,
            ]);
            $this->resourceRepository->persist($workspace);
        } catch (ResourceNotFoundExceptionInterface) {
            return;
        }
    }

}
