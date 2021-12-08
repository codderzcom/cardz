<?php

namespace Cardz\Core\Workspaces\Integration\Consumers;

use Cardz\Core\Personal\Integration\Events\PersonJoined;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class NewKeeperRegisteredConsumer implements IntegrationEventConsumerInterface
{
    public function consumes(): array
    {
        return [
            PersonJoined::class,
        ];
    }

    public function handle(string $event): void
    {

    }

}
