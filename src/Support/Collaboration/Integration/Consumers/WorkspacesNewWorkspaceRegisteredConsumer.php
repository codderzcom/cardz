<?php

namespace Cardz\Support\Collaboration\Integration\Consumers;

use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Cardz\Support\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

final class WorkspacesNewWorkspaceRegisteredConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function consumes(): array
    {
        //ToDo: intercontext interaction
        return [
            NewWorkspaceRegistered::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            return;
        }

        $this->commandBus->dispatch(KeepWorkspace::of($payload->keeperId, $payload->workspaceId));
    }

}
