<?php

namespace Cardz\Core\Workspaces\Application\Consumers;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Contracts\ReadWorkspaceStorageInterface;
use Cardz\Core\Workspaces\Integration\Events\WorkspaceChanged;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceChangedDomainConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        protected ReadWorkspaceStorageInterface $readWorkspaceStorage,
    ) {
    }

    public function consumes(): array
    {
        return [
            WorkspaceProfileChanged::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        $workspace = $this->readWorkspaceStorage->take((string) $event->with()?->workspaceId);
        if ($workspace === null) {
            return;
        }

        $this->integrationEventBus->publish(WorkspaceChanged::of($workspace));
    }

}
