<?php

namespace Cardz\Core\Workspaces\Integration\Consumers;

use Cardz\Core\Personal\Integration\Events\PersonJoined;
use Cardz\Core\Workspaces\Application\Commands\RegisterKeeper;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

final class KeeperRegisteredConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

    use SimpleLoggerTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            PersonJoined::class,
        ];
    }

    public function handle(string $event): void
    {
        $keeperId = $this->getPayloadOrNull($event)?->personId;
        if (!$keeperId) {
            $this->error("Incomprehensible 'PersonJoined' event", ['event' => $event]);
            return;
        }
        $this->commandBus->dispatch(RegisterKeeper::of($keeperId));
    }

}
