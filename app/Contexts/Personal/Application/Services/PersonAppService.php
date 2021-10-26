<?php

namespace App\Contexts\Personal\Application\Services;

use App\Contexts\Personal\Application\Commands\ChangePersonName;
use App\Contexts\Personal\Application\Commands\JoinPerson;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Infrastructure\Messaging\DomainEventBusInterface;

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
