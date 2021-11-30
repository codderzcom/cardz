<?php

namespace Cardz\Core\Workspaces\Application\Consumers;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceAdded;
use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceAddedDomainConsumer implements EventConsumerInterface
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
