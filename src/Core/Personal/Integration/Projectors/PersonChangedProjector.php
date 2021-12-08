<?php

namespace Cardz\Core\Personal\Integration\Projectors;

use Cardz\Core\Personal\Domain\ReadModel\Contracts\JoinedPersonStorageInterface;
use Cardz\Core\Personal\Integration\Events\PersonJoined;
use Cardz\Core\Personal\Integration\Events\PersonNameChanged;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

final class PersonChangedProjector implements IntegrationEventConsumerInterface
{
    public function __construct(
        private IntegrationEventToJoinedPersonMapper $mapper,
        private JoinedPersonStorageInterface $joinedPersonStorage,
    )
    {
    }

    public function consumes(): array
    {
        //ToDo: коннект к другому контексту
        return [
            PersonJoined::class,
            PersonNameChanged::class,
        ];
    }

    public function handle(string $event): void
    {
        $joinedPerson = $this->mapper->map($event);
        if (!$joinedPerson) {
            return;
        }

        $this->joinedPersonStorage->persist($joinedPerson);
    }

}
