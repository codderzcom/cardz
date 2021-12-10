<?php

namespace Cardz\Core\Workspaces\Application\Consumers;

use Cardz\Core\Workspaces\Domain\Events\Workspace\WorkspaceProfileChanged;
use Cardz\Core\Workspaces\Domain\ReadModel\AddedWorkspace;
use Cardz\Core\Workspaces\Domain\ReadModel\Contracts\AddedWorkspaceStorageInterface;
use Cardz\Core\Workspaces\Integration\Events\WorkspaceChanged;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class WorkspaceChangedDomainConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        protected AddedWorkspaceStorageInterface $readWorkspaceStorage,
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
        /** @var WorkspaceProfileChanged $event */
        $this->integrationEventBus->publish(WorkspaceChanged::of(AddedWorkspace::of($event->with())));
    }

}
