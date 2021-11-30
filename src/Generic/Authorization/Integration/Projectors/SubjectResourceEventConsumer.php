<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Generic\Identity\Integration\Events\RegistrationCompleted;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class SubjectResourceEventConsumer implements IntegrationEventConsumerInterface
{
    public function consumes(): array
    {
        return [
            RegistrationCompleted::class,
        ];
    }

    public function handle(string $event): void
    {
    }

}
