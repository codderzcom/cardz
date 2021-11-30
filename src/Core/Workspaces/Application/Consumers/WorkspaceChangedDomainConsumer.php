<?php

namespace Cardz\Core\Workspaces\Application\Consumers;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Cardz\Core\Workspaces\Integration\Events\WorkspaceChanged;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceChangedDomainConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
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
        if (!($event instanceof WorkspaceProfileChanged)) {
            return;
        }

        $this->integrationEventBus->publish(WorkspaceChanged::of($event->with()));
    }

}
