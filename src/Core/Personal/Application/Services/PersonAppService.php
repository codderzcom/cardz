<?php

namespace Cardz\Core\Personal\Application\Services;

use Cardz\Core\Personal\Application\Commands\ChangePersonName;
use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Core\Personal\Infrastructure\Persistence\Eloquent\PersonStore;

class PersonAppService
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private DomainEventBusInterface $domainEventBus,
        private PersonStore $personStore,
    ) {
    }

    public function join(JoinPerson $command): PersonId
    {
        $person = Person::join($command->getPersonId(), $command->getName());
        $events = $person->releaseEvents();
        $this->personStore->store(...$events);
        $this->domainEventBus->publish(...$events);
        return $person->personId;
    }

    public function changeName(ChangePersonName $command): PersonId
    {
        $person = $this->personStore->restore($command->getPersonId());
        $person->changeName($command->getName());
        $events = $person->releaseEvents();
        $this->personStore->store(...$events);
        $this->domainEventBus->publish(...$events);
        return $person->personId;
    }
}
