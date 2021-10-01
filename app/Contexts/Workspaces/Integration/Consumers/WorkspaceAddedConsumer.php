<?php

namespace App\Contexts\Workspaces\Integration\Consumers;

use App\Contexts\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use App\Contexts\Workspaces\Integration\Events\NewWorkspaceRegistered;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceAddedConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
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
        if (!($event instanceof WorkspaceAdded)) {
            return;
        }

        $this->integrationEventBus->publish(NewWorkspaceRegistered::of($event->with()));
    }

}
