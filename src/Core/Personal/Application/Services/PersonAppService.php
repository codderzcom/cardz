<?php

namespace Cardz\Core\Personal\Application\Services;

use Cardz\Core\Personal\Application\Commands\ChangePersonName;
use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Infrastructure\Messaging\DomainEventBusInterface;

class PersonAppService
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function join(JoinPerson $command): PersonId
    {
        $person = Person::join($command->getPersonId(), $command->getName());
        $this->personRepository->persist($person);
        $this->domainEventBus->publish(...$person->releaseEvents());
        return $person->personId;
    }

    public function changeName(ChangePersonName $command): PersonId
    {
        $person = $this->personRepository->take($command->getPersonId());
        $person->changeName($command->getName());
        $this->personRepository->persist($person);
        $this->domainEventBus->publish(...$person->releaseEvents());
        return $person->personId;
    }
}
