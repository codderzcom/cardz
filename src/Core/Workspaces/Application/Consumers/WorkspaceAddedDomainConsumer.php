<?php

namespace Cardz\Core\Workspaces\Application\Consumers;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Contracts\ReadWorkspaceStorageInterface;
use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceAddedDomainConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        private ReadWorkspaceStorageInterface $readWorkspaceStorage,
    ) {
    }

    public function consumes(): array
    {
        return [
            WorkspaceAdded::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        $workspace = $this->readWorkspaceStorage->take((string) $event->with()?->workspaceId);
        if ($workspace === null) {
            return;
        }

        $this->integrationEventBus->publish(NewWorkspaceRegistered::of($workspace));
    }

}
